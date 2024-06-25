<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Reserva;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportForDay;
use Illuminate\Support\Arr;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $query2 = trim($request->get('searchText2'));
            $query3 = trim($request->get('metodoPago'));

            $query = $query == '' ? date('Y-m-d') : $query;


            $registro = [];
            $pago = DB::table('pago as p')->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
                ->where('FechaPago', 'LIKE', '%' . $query . '%')
                ->get();

            $salida_alquiler = DB::table('ingreso_caja as ic')->join('reserva as r', 'ic.IdReserva',  'r.IdReserva')
                ->where('fechaIngreso', $query)
                ->where('motivo', 'ALQUILER')
                ->select('horaIngreso', 'Num_Hab', 'ic.metodoPago', 'importe')
                ->get();

            $penalidad = DB::table('ingreso_caja as ic')->join('reserva as r', 'ic.IdReserva',  'r.IdReserva')
                ->where('fechaIngreso', $query)
                ->where('motivo', 'PENALIDAD')
                ->select('horaIngreso', 'Num_Hab', 'ic.metodoPago', 'importe')
                ->get();

            // $renovacion = DB::table('renovacion as ren')
            //     ->join('reserva as res', 'ren.IdReserva',  'res.IdReserva')
            //     ->whereBetween('fRenovacion', [$query . ' 00:00:01', $query . ' 23:59:59'])
            //     ->get();

            $pagos = DB::table('pagos as p')->join('reserva as r', 'p.IdReserva',  'r.IdReserva')
                ->whereBetween('fecPag', [$query . ' 00:00:01', $query . ' 23:59:59'])
                ->get();


            $consumo = DB::table('consumo as c')->join('reserva as r', 'c.IdReserva', 'r.IdReserva')
                ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
                ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
                ->select('FechaPago', 'Denominacion', 'Num_Hab', 'c.metodoPago', 'Total', 'IdConsumo')
                ->where('c.Estado', 'PAGADO')
                ->whereBetween('FechaPago', [$query . ' 00:00:01', $query . ' 23:59:59'])
                ->get();

            $venta = DB::table('venta as v')->where('fechaVenta', $query)
                ->join('cliente as c', 'v.IdCliente',  'c.IdCliente')
                ->get();


            // ----------------------------------------------------------------------------------------------

            foreach ($pago as $p) {
                if ($p->TotalPago != 0) {
                    $registro[] = array(
                        'hora' => explode(' ', $p->FechaPago)[1], "tipo" => 'ALQUILER',
                        'motivo' => 'INGRESO ALQUILER', 'entidad' => 'Hab. N°: ' . $p->Num_Hab, "metodoPago" => $p->metodoPago, 'monto' => $p->TotalPago
                    );
                }
            }


            foreach ($salida_alquiler as $sa) {
                $registro[] = array(
                    'hora' => $sa->horaIngreso, "tipo" => 'ALQUILER',
                    'motivo' => 'SALIDA ALQUILER', 'entidad' => 'Hab. N°: ' . $sa->Num_Hab, "metodoPago" => $sa->metodoPago, 'monto' => $sa->importe
                );
            }

            foreach ($penalidad as $pe) {
                $registro[] = array(
                    'hora' => $pe->horaIngreso, "tipo" => 'ALQUILER',
                    'motivo' => 'PENALIDAD', 'entidad' => 'Hab. N°: ' . $pe->Num_Hab, "metodoPago" => $pe->metodoPago, 'monto' => $pe->importe
                );
            }

            // foreach ($renovacion as $re) {
            //     $registro[] = array('hora'=> date('H:i:s', strtotime($re->fRenovacion)), "tipo" => 'ALQUILER',
            //      'motivo'=>'RENOVACIÓN', 'entidad'=> 'Hab. N°: '. $re->Num_Hab, "metodoPago"=> $re->metPagRen, 'monto'=> $re->cosRen);
            // }

            foreach ($pagos as $pa) {
                $registro[] = array(
                    'hora' => date('H:i:s', strtotime($pa->fecPag)), "tipo" => 'ALQUILER',
                    'motivo' => 'PAGOS', 'entidad' => 'Hab. N°: ' . $pa->Num_Hab, "metodoPago" => $pa->metPag, 'monto' => $pa->monPag
                );
            }

            foreach ($consumo as $co) {
                $registro[] = array(
                    'hora' => explode(' ', $co->FechaPago)[1], "tipo" => $co->Denominacion == 'Servicio' ? 'SERVICIO' : 'CONSUMO',
                    'motivo' => '',
                    'entidad' => 'Hab. N°: ' . $co->Num_Hab, "metodoPago" => $co->metodoPago, 'monto' => $co->Total
                );
            }

            foreach ($venta as $ve) {
                $registro[] = array(
                    'hora' => $ve->horaVenta, "tipo" => 'VENTA',
                    'motivo' => '',
                    'entidad' => $ve->Nombre, "metodoPago" => $ve->metodoPago, 'monto' => $ve->totalVenta
                );
            }


            $registro = collect($registro)
                ->where('metodoPago', empty($query3) ? '!=' : '=', empty($query3) ? -1 : $query3)
                ->where('tipo', empty($query2) ? '!=' : '=', empty($query2) ? -1 : $query2)
                ->sortByDesc('hora')
                ->all();

            $responsable = DB::table('usuario as r')->get();

            return view('reporte.ingresos.index', [
                "registro" => $registro, "searchText" => $query,
                "searchText2" => $query2, "responsable" => $responsable, 'metodoPago' => $query3
            ]);
        }
    }

    public function exportExcel($f1, $f2, $f3)
    {
        return Excel::download(new ReportForDay($f1, $f2, $f3), 'reporte_por_dia.xlsx');
    }
}
