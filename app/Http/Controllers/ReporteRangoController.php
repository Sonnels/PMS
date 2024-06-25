<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportRange;

class ReporteRangoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $start = date('Y-m-01', strtotime($fecha));

        if ($request) {
            $query = trim($request->get('searchText'));
            $query2 = trim($request->get('searchText2'));
            $query3 = trim($request->get('searchText3'));

            $query = empty($query) ? $start : $query;
            $query2 = empty($query2) ? $fecha : $query2;
            $query3 = $query3 == 'TODO'?'':$query3;


            $registro = DB::table('pago as p')->join('reserva as r', 'p.IdReserva', 'r.IdReserva')->join('cliente as c', 'r.IdCliente', 'c.IdCliente')
            ->whereBetween('FechReserva', [$query, $query2])
            ->Where(function ($q)  use ($query3) {
            $q->orWhere('r.Estado', 'LIKE', '%' . $query3 . '%')
                ->orWhere('c.Nombre', 'LIKE', '%' . $query3 . '%')
                ->orWhere('r.Num_Hab', $query3)
                ->orWhere('servicio', 'LIKE', '%' . $query3 . '%');
            })
            ->orderByDesc('r.IdReserva')->get();



            $consumo = DB::table('consumo as c')
                ->select(DB::raw('SUM(Total) as total'), 'IdReserva')
                ->where('Estado', 'PAGADO')
                ->where('metodoPago', '!=', 'CORTESIA')
                ->groupBy('IdReserva')
                // ->orderByDesc(DB::raw('SUM(2)'))
                ->get();


            return view('reporte.rango.index', ["registro" => $registro, "consumo" => $consumo, "fecha" => $fecha,
                        "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3]);
        }
    }

    public function exportExcel($f1, $f2, $f3){
        return Excel::download(new ReportRange($f1, $f2, $f3), 'reporte_rango.xlsx');
    }
}
