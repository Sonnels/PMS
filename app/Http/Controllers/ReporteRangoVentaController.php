<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportRange;

class ReporteRangoVentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $start = Carbon::now()->startOfYear()->toDateString();

        if ($request) {
            $query = trim($request->get('searchText'));
            $query2 = trim($request->get('searchText2'));
            $query3 = trim($request->get('searchText3'));

            $query = empty($query) ? $start : $query;
            $query2 = empty($query2) ? $fecha : $query2;
            $query3 = $query3 == 'TODO'?'':$query3;

        // $registro = DB::table('detalle_venta as dv')
        //     ->join('producto as p', 'dv.IdProducto', 'p.IdProducto')
        //     ->join('venta as v', 'dv.codVenta','=', 'v.codVenta')
        //     ->whereBetween('fechaVenta', [$query, $query2])
        //     ->select(DB::raw('SUM(cantidad) as cantidad'), 'NombProducto', 'fechaVenta', 'dv.IdProducto')
        //     ->Where(function ($q)  use ($query3) {
        //         $q->orWhere('NombProducto', 'LIKE', '%' . $query3 . '%');
        //     })
        //     ->groupBy('dv.IdProducto', 'NombProducto', 'fechaVenta')
        //     ->orderByDesc('fechaVenta')
        //     ->get();

        // $consumo = DB::table('consumo as c')
        //         ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
        //         ->whereBetween('FechConsumo', [$query, $query2])
        //         ->select(DB::raw('SUM(Cantidad) as Cantidad'), 'NombProducto', 'FechConsumo', 'c.IdProducto')
        //         ->Where(function ($q)  use ($query3) {
        //             $q->orWhere('NombProducto', 'LIKE', '%' . $query3 . '%');
        //         })
        //         ->where('Estado', 'PAGADO')
        //         ->groupBy('c.IdProducto','NombProducto', 'FechConsumo')
        //         ->orderByDesc('FechConsumo')
        //     ->get();

        $registro = DB::table('detalle_venta as dv')
            ->join('producto as p', 'dv.IdProducto', 'p.IdProducto')
            ->join('venta as v', 'dv.codVenta','=', 'v.codVenta')
            ->whereBetween('fechaVenta', [$query, $query2])
            ->select('fechaVenta', 'NombProducto', DB::raw('SUM(cantidad) as cantidad'), 'precioVenta')
            ->Where(function ($q)  use ($query3) {
                $q->orWhere('NombProducto', 'LIKE', '%' . $query3 . '%');
            })
            ->groupBy('NombProducto', 'fechaVenta', 'precioVenta')
            ->orderByDesc('fechaVenta')
            ->get();

        $consumo = DB::table('consumo as c')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->whereBetween('FechConsumo', [$query, $query2])
            ->select('FechConsumo', 'NombProducto', DB::raw('SUM(Cantidad) as cantidad'), 'precioVenta')
            ->Where(function ($q)  use ($query3) {
                $q->orWhere('NombProducto', 'LIKE', '%' . $query3 . '%');
            })
            ->where('Estado', 'PAGADO')
            ->where('IdCategoria', '!=', 1)
            ->groupBy('NombProducto', 'FechConsumo', 'precioVenta')
            ->orderByDesc('FechConsumo')
            ->get();


        $k = 0;
        $data = array();
        foreach($registro as $r){
            $data[$k] = array($r->NombProducto, $r->fechaVenta,$r->cantidad, $r->precioVenta);
            $k += 1;
        }

        $tamanio =  count($data);
        foreach($consumo as $c){
            $i = 0;
            $flag = false;
            while($i < $tamanio){
                if ($c->NombProducto == $data[$i][0] &&  $c->FechConsumo  == $data[$i][1]  && $c->precioVenta == $data[$i][3] ){
                    $data[$i][2] += $c->cantidad;
                    $flag = true;
                }
                $i += 1;
            }
            $r = 0;
            if (!$flag){
                $data[$k] = array($c->NombProducto, $c->FechConsumo, $c->cantidad, $c->precioVenta);
            }

            $k += 1;
        }

        if (count($data) > 0) {
            $data = $this->OrdenarMatrizColumna($data, 1,'DESC');
        }



            return view('reporte.rango_venta.index', ["registro" => $data, "fecha" => $fecha,
                        "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3]);
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
