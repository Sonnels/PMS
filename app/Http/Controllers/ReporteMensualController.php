<?php

namespace App\Http\Controllers;

use App\Datos;
use App\Egreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportForMonth;
use App\IngresoCaja;
use Illuminate\Support\Carbon;

class ReporteMensualController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        if ($request) {
            $mes = trim($request->get('searchText'));
            $anio = trim($request->get('searchText2'));

            //Array de meses
            $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

            //Array de anios
            $anio_actual = intval(date('Y')) - 5;
            for ($p = 0; $p <= 5; $p++) {
                $anios_vista[$p] = $anio_actual++;
            }
            if ($mes == '') {
                $mes = date('m');
            }
            if ($anio == '') {
                $anio = date('Y');
            }

            // Si no se encuentra seleccionada nigun mes

            $fecha_actual = date($anio . '-' . str_pad($mes, 2, "0", STR_PAD_LEFT) . '-d');
            $dias_del_mes = date('t', strtotime($fecha_actual));

            $monto_alquiler = 0;
            for ($i = 0; $i < $dias_del_mes; $i++) {
                $valor_fecha = date('Y', strtotime($fecha_actual)) . '-' . date('m', strtotime($fecha_actual)) . '-' . str_pad(strval($i + 1), 2, "0", STR_PAD_LEFT);
                // Consulta de Consumos
                $Consumo = DB::table('consumo as co')
                    ->join('producto as p', 'co.IdProducto', 'p.IdProducto')
                    ->select(DB::raw('SUM(Total) as TotalConsumo'))
                    ->where('Estado', 'PAGADO')
                    ->where('metodoPago', '!=', 'CORTESIA')
                    ->where('FechaPago', 'LIKE', '%' . date('Y-m-d', strtotime($valor_fecha)) . '%')
                    ->where('IdCategoria', '!=', 1)
                    ->first();

                $servicio = DB::table('consumo as co')
                    ->join('producto as p', 'co.IdProducto', 'p.IdProducto')
                    ->select(DB::raw('SUM(Total) as TotalConsumo'))
                    ->where('Estado', 'PAGADO')
                    ->where('metodoPago', '!=', 'CORTESIA')
                    ->where('FechaPago', 'LIKE', '%' . date('Y-m-d', strtotime($valor_fecha)) . '%')
                    ->where('IdCategoria', 1)
                    ->first();

                $venta = DB::table('venta')->select(DB::raw('SUM(totalVenta) as totalVenta'))
                    ->Where('fechaVenta', date('Y-m-d', strtotime($valor_fecha)))
                    ->where('metodoPago', '!=', 'CORTESIA')
                    ->first();

                $pago = DB::table('pago as p')
                    ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')->select(DB::raw('SUM(TotalPago) as TotalPago'))
                    ->where('r.Estado', '!=', 'RESERVAR')
                    ->where('FechEntrada', '=', date('Y-m-d', strtotime($valor_fecha)))
                    ->first();

                $pago2 = DB::table('pago as p')
                    ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')->select(DB::raw('SUM(Pago2) as Pago2'))
                    ->where('r.Estado', '!=', 'RESERVAR')
                    ->where('FechaEmision', 'LIKE', '%' . date('Y-m-d', strtotime($valor_fecha)) . '%')
                    ->first();

                $pago3 = DB::table('pago as p')
                    ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')->select(DB::raw('SUM(Penalidad) as Penalidad'))
                    ->where('r.Estado', '!=', 'RESERVAR')
                    ->where('FechaEmision', 'LIKE', '%' . date('Y-m-d', strtotime($valor_fecha)) . '%')
                    ->first();

                $deuda_alquiler = DB::table('ingreso_caja')
                    ->select(DB::raw('SUM(importe) as importe'))
                    ->where('motivo', 'ALQUILER')
                    ->where('fechaIngreso', date('Y-m-d', strtotime($valor_fecha)))
                    ->first();

                $pagos = DB::table('pagos')->select(DB::raw('SUM(monPag) as total'))
                    ->whereBetween('fecPag', [$valor_fecha . ' 00:00:01', $valor_fecha . ' 23:59:59'])
                    ->first();

                $ingreso = IngresoCaja::where('fechaIngreso', $valor_fecha)
                    ->where('motivo','NOT LIKE', 'ALQUILER' .'%')
                    ->where('motivo','NOT LIKE', 'PENALIDAD' .'%')
                    ->select(DB::raw('SUM(importe) as total'))
                    ->first();

                $egreso = Egreso::where('fechaEgreso', $valor_fecha)
                    ->select(DB::raw('SUM(importe) as total'))
                    ->first();
                // $renovacion = DB::table('renovacion as r')
                //     ->select(DB::raw('SUM(cosRen) as monto'))
                //     ->where('fRenovacion', 'LIKE', '%' . date('Y-m-d', strtotime($valor_fecha)) . '%')
                //     ->first();

                $venta = $venta->totalVenta;
                $servicio = $servicio->TotalConsumo;
                $consumo = $Consumo->TotalConsumo;
                $ingreso = $ingreso->total;
                $egreso = $egreso->total;

                $monto_alquiler = $pago->TotalPago + $pago2->Pago2 + $pago3->Penalidad + $deuda_alquiler->importe + $pagos->total;

                $array_fechas[$i] = $valor_fecha . '_' . $venta . '_' . $servicio . '_' . $consumo . '_' . $monto_alquiler . '_' . $ingreso . '_' . $egreso;
            }

            $datos_hotel = Datos::first();

            return view('reporte.mensual.index', [
                "array_fechas" => $array_fechas, "datos_hotel" => $datos_hotel,
                "searchText" => $mes, "searchText2" => $anio, "meses" => $meses, "anios_vista" => $anios_vista, "fecha" => $fecha
            ]);
        }
    }

    public function exportExcel($f1, $f2)
    {
        return Excel::download(new ReportForMonth($f1, $f2), 'reporte_por_mes.xlsx');
    }
}
