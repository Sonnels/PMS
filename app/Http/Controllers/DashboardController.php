<?php

namespace App\Http\Controllers;

use App\Apartar;
use App\Egreso;
use App\IngresoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha_hora = $mytime->toDateTimeString();
       if($request)
        {
             // Si no se encuentra seleccionada nigun mes
             $dias_del_mes = date('t', strtotime(date('Y-m-d')));

             $monto_alquiler = 0;
             for ($i=0; $i < $dias_del_mes; $i++) {
                $valor_fecha = date('Y', strtotime($mytime->toDateString())) . '-' . date('m', strtotime($mytime->toDateString())) . '-' . str_pad(strval($i + 1), 2, "0", STR_PAD_LEFT);
                 // Consulta de Consumos
                 $Consumo = DB::table('consumo')
                 ->select(DB::raw('SUM(Total) as TotalConsumo'))
                 ->where('Estado' ,'=', 'PAGADO')
                 ->Where(function($query)  use ($valor_fecha){
                     $query->orwhere('FechaPago','LIKE','%'. $valor_fecha .'%')
                         ->orwhere('FechConsumo','LIKE','%'. $valor_fecha .'%');
                 })
                 ->first();

                $servicio = DB::table('consumo as co')
                    ->join('producto as p', 'co.IdProducto', 'p.IdProducto')
                    ->select(DB::raw('SUM(Total) as TotalConsumo'))
                    ->where('Estado', 'PAGADO')
                    ->where('metodoPago', '!=', 'CORTESIA')
                    ->where('FechaPago', 'LIKE', '%' . $valor_fecha . '%')
                    ->where('IdCategoria', 1)
                    ->first();

                $venta = DB::table('venta')->select(DB::raw('SUM(totalVenta) as totalVenta'))
                    ->Where('fechaVenta', $valor_fecha)
                    ->first();

                $pago=DB::table('pago as p')
                    ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')->select(DB::raw('SUM(TotalPago) as TotalPago'))
                    ->where('r.Estado','!=','RESERVAR')
                    ->where('FechEntrada', '=', $valor_fecha)
                    ->first();
                 $pago2=DB::table('pago as p')
                    ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')->select(DB::raw('SUM(Pago2) as Pago2'))
                    ->where('r.Estado','!=','RESERVAR')
                    ->where('FechaEmision','LIKE','%'. $valor_fecha .'%')
                    ->first();

                 $pago3=DB::table('pago as p')
                    ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')->select(DB::raw('SUM(Penalidad) as Penalidad'))
                    ->where('r.Estado','!=','RESERVAR')
                    ->where('FechaEmision','LIKE','%'. $valor_fecha .'%')
                    ->first();

                $deuda_alquiler = DB::table('ingreso_caja')
                    ->select(DB::raw('SUM(importe) as importe'))
                    ->where('motivo', 'ALQUILER')
                    ->where('fechaIngreso', $valor_fecha)
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

                $venta = $venta->totalVenta;
                $servicio = $servicio->TotalConsumo;
                $consumo = $Consumo->TotalConsumo;
                $ingreso = $ingreso->total;
                $egreso = $egreso->total;

                $monto_alquiler = $pago->TotalPago + $pago2->Pago2 + $pago3->Penalidad + $deuda_alquiler->importe + $pagos->total;

                //  $array_fechas[$i] = $valor_fecha . '_' . $Consumo->TotalConsumo . '_' . $monto_alquiler;
                $array_fechas[$i] = $valor_fecha;
                $array_consumo[$i] = ($consumo + $servicio + $venta);
                $array_alquiler[$i] = $monto_alquiler;
                $array_ingresoExtra[$i] = $ingreso;
                $array_egreso[$i] = $egreso;

            }

            //  Habitaciones que necesitan atenciòn
            $hab_por_salir = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->select(DB::raw('COUNT(IdPago) as TotalHab'))
            ->where('r.Estado', 'HOSPEDAR')
            ->where('departure_date', '<=', $fecha_hora)
            ->first();

            // Habitaciones Disponibles
            $hab_disponible = DB::table('habitacion')
            ->select(DB::raw('COUNT(Num_Hab) as TotalHab'))
            ->where('Estado', '=', 'DISPONIBLE')
            ->first();

            // Habitaciones Reservadas
            $hab_reservada = Apartar::select(DB::raw('COUNT(*) as TotalHab'))
            ->first();

            // Habitaciones Ocupadas
            $hab_ocupada = DB::table('habitacion')
            ->select(DB::raw('COUNT(Num_Hab) as TotalHab'))
            ->where('Estado', '=', 'OCUPADO')
            ->first();

        // Productos más consumidos
        $registro = DB::table('detalle_venta as dv')
            ->join('producto as p', 'dv.IdProducto', 'p.IdProducto')
            ->join('venta as v', 'dv.codVenta','=', 'v.codVenta')
            // ->whereBetween('fechaVenta', [$query, $query2])
            ->select('NombProducto', DB::raw('SUM(cantidad) as cantidad'))
            // ->Where(function ($q)  use ($query3) {
            //     $q->orWhere('NombProducto', 'LIKE', '%' . $query3 . '%');
            // })
            ->groupBy('NombProducto')
            // ->orderByDesc('fechaVenta')
            ->get();

        $consumo = DB::table('consumo as c')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->where('IdCategoria', '!=', 1)
            // ->whereBetween('FechConsumo', [$query, $query2])
            ->select('NombProducto', DB::raw('SUM(Cantidad) as cantidad'))
            // ->Where(function ($q)  use ($query3) {
            //     $q->orWhere('NombProducto', 'LIKE', '%' . $query3 . '%');
            // })
            ->where('Estado', 'PAGADO')
            ->groupBy('NombProducto')
            // ->orderByDesc('FechConsumo')
            ->get();

            $k = 0;
            $data = array();
            foreach($registro as $r){
                $data[$k] = array($r->NombProducto,$r->cantidad);
                $k += 1;
            }

            $tamanio =  count($data);
            foreach($consumo as $c){
                $i = 0;
                $flag = false;
                while($i < $tamanio){
                    if ($c->NombProducto == $data[$i][0]){
                        $data[$i][1] += $c->cantidad;
                        $flag = true;
                    }
                    $i += 1;
                }
                $r = 0;
                if (!$flag){
                    $data[$k] = array($c->NombProducto, $c->cantidad);
                }

                $k += 1;
            }

        if (count($data) > 1) {
            $data = $this->OrdenarMatrizColumna($data, 1,'DESC');
        }



        // $pro_consu = DB::table('consumo as c')
        //     ->join('producto as p', 'c.IdProducto', '=', 'p.IdProducto')
        //     ->select(DB::raw('SUM(cantidad) as Cantidad'), 'p.NombProducto')
        //     ->groupBy('p.NombProducto')
        //     ->orderByDesc('Cantidad')
        //     ->limit(5)
        //     ->get();

        // foreach ($data as $key) {
        //     list($n, $c) = $key;
        //     echo $n . ' '  . $c .'<br>';
        // }

            return view('reserva.dashboard.index',["data"=>$data,"hab_ocupada"=>$hab_ocupada, "hab_por_salir"=>$hab_por_salir, "hab_disponible"=>$hab_disponible,
              "hab_reservada"=>$hab_reservada,"array_fechas"=>$array_fechas, "array_consumo"=>$array_consumo, "array_alquiler"=>$array_alquiler,
                "array_ingresoExtra" => $array_ingresoExtra, "array_egreso"=> $array_egreso]);
          }
    }

    public function OrdenarMatrizColumna(array $MatrizRegistros, $Columna = false, $Orden = false) {
        if (is_array($MatrizRegistros) == true and $Columna == true and $Orden == true) {
            $Orden = ($Orden == "ASC") ? SORT_ASC : SORT_DESC;
            foreach ($MatrizRegistros as $Arreglo) {
                $Lista[] = $Arreglo[$Columna];
            }
            array_multisort($Lista, $Orden, $MatrizRegistros);
            return $MatrizRegistros;
        }
    }
}
