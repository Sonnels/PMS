<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteCajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        if ($request) {
            $caja = DB::table('caja as c')->join('usuario as u', 'c.codUsuario', 'u.IdUsuario')
                ->orwhere('u.Nombre', 'LIKE', '%' . $query . '%')
                ->orderByDesc('c.codCaja')
                ->orderByDesc('c.fechaApertura')
                ->paginate(10);
            return view('reporte.caja.index', ["caja" => $caja, "searchText" => $query]);
        }
    }
}
