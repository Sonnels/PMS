<?php

namespace App\Exports;

use App\Egreso;
use App\IngresoCaja;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ReportForMonth implements FromView, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $f1, $f2;
    public function __construct($f1, $f2){

        $this->f1 = $f1;
        $this->f2 = $f2;

    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_00,
            'D' => NumberFormat::FORMAT_NUMBER_00,
            'E' => NumberFormat::FORMAT_NUMBER_00,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'G' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_NUMBER_00,
            'I' => NumberFormat::FORMAT_NUMBER_00
        ];
    }

    public function view(): View{
        //
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        // --------------------------------------

        $mes = $this->f1;
        $anio = $this->f2;

        //Array de meses
        $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

        //Array de anios
        $anio_actual = intval(date('Y'))-5;
        for ($p=0; $p <= 5; $p++) {
            $anios_vista[$p] = $anio_actual++;
        }
        if ($mes == ''){
            $mes = date('m');
        }
        if($anio == ''){
            $anio = date('Y');
        }

        // Si no se encuentra seleccionada nigun mes

        $fecha_actual = date($anio . '-'. str_pad($mes, 2, "0", STR_PAD_LEFT) . '-d');
        $dias_del_mes = date('t', strtotime($fecha_actual));

        $monto_alquiler = 0;
        for ($i=0; $i < $dias_del_mes; $i++) {
            $valor_fecha = date('Y', strtotime($fecha_actual)) . '-' . date('m', strtotime($fecha_actual)) . '-' . str_pad(strval($i + 1), 2, "0", STR_PAD_LEFT);
            // Consulta de Consumos
            $Consumo = DB::table('consumo as co')
            ->join('producto as p', 'co.IdProducto', 'p.IdProducto')
            ->select(DB::raw('SUM(Total) as TotalConsumo'))
            ->where('Estado' , 'PAGADO')
            ->where('metodoPago', '!=', 'CORTESIA')
            ->where('FechaPago','LIKE','%'. date('Y-m-d', strtotime($valor_fecha)).'%')
            ->where('IdCategoria', '!=', 1)
            ->first();

            $servicio = DB::table('consumo as co')
                ->join('producto as p', 'co.IdProducto', 'p.IdProducto')
                ->select(DB::raw('SUM(Total) as TotalConsumo'))
                ->where('Estado' , 'PAGADO')
                ->where('metodoPago', '!=', 'CORTESIA')
                ->where('FechaPago','LIKE','%'. date('Y-m-d', strtotime($valor_fecha)).'%')
                ->where('IdCategoria', 1)
                ->first();

            $venta = DB::table('venta')->select(DB::raw('SUM(totalVenta) as totalVenta'))
                ->Where('fechaVenta', date('Y-m-d', strtotime($valor_fecha)))
                ->where('metodoPago', '!=', 'CORTESIA')
                ->first();

            $pago=DB::table('pago as p')
                ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')->select(DB::raw('SUM(TotalPago) as TotalPago'))
                ->where('r.Estado','!=','RESERVAR')
                ->where('FechEntrada', '=', date('Y-m-d', strtotime($valor_fecha)))
                ->first();

            $pago2=DB::table('pago as p')
                ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')->select(DB::raw('SUM(Pago2) as Pago2'))
                ->where('r.Estado','!=','RESERVAR')
                ->where('FechaEmision','LIKE','%'. date('Y-m-d', strtotime($valor_fecha)).'%')
                ->first();

            $pago3=DB::table('pago as p')
                ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')->select(DB::raw('SUM(Penalidad) as Penalidad'))
                ->where('r.Estado','!=','RESERVAR')
                ->where('FechaEmision','LIKE','%'. date('Y-m-d', strtotime($valor_fecha)).'%')
                ->first();

            $deuda_alquiler =DB::table('ingreso_caja')
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

        return view('exports.reportformonth', ["array_fechas"=>$array_fechas,
        "searchText"=>$mes, "searchText2"=>$anio, "meses"=>$meses, "anios_vista"=>$anios_vista, "fecha"=>$fecha]);
    }
}
