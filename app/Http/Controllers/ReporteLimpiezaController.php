<?php

namespace App\Http\Controllers;

use App\Datos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteLimpiezaController extends Controller
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


            $limpieza = DB::table('det_limpieza as d')->join('tipo_limpieza as t', 'd.idLim', 't.idLim')
            ->join('personal as p', 'd.idPer', 'p.idPer')
            ->where('nomPer','LIKE','%'. $query3 .'%')
            ->whereBetween('fechaDetLim', array($query, $query2))
            ->paginate(10);

            return view('reporte.limpieza.index', ["limpieza" => $limpieza, "fecha" => $fecha,
                        "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3]);
        }
    }

    public function list_limpieza ($query, $query2, $query3){
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        $query3 = $query3 == 'TODO'?'':$query3;

        $limpieza = DB::table('det_limpieza as d')->join('tipo_limpieza as t', 'd.idLim', 't.idLim')
        ->join('personal as p', 'd.idPer', 'p.idPer')
        ->where('nomPer','LIKE','%'. $query3 .'%')
        ->whereBetween('fechaDetLim', array($query, $query2))
        ->get();

        $datos_hotel = Datos::first();

        $pdf = \PDF::loadView('reporte.limpieza.list', ["limpieza"=>$limpieza, "datos_hotel"=>$datos_hotel, "fechaHora"=>$fechaHora]);
        // ->setPaper('a4', 'landscape');
        return $pdf->stream();

    }
}
