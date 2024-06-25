<?php

namespace App\Http\Controllers;

use App\RespAlquiler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RespAlquilerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $searchText = $request->get('searchText');
            $res_alquiler = DB::table('resp_alquiler as r')->join('cliente as c', 'r.IdCliente', 'c.IdCliente')
                ->join('usuario as u', 'r.IdUsuario', 'u.IdUsuario')
                ->select(
                    'idResAlq',
                    'IdReserva',
                    'fechEntrada',
                    'horaEntrada',
                    'fechSalida',
                    'horaSalida',
                    'costoAlojamiento',
                    'numHab',
                    'c.Nombre as nomCliente',
                    'u.Nombre as nomUsuario',
                    'motElim',
                    'fechElim',
                    'horaElim'
                )
                // ->where('Denominacion','LIKE','%'.$query.'%')
                ->paginate(15);

            return view('respaldo.r_alquiler.index', compact("res_alquiler", "searchText"));
        }
    }

    public function destroy(Request $request, $id)
    {

        $res_alquiler = RespAlquiler::findOrFail($id);
        try {
            if ($request->ajax()) {
                if ($res_alquiler->delete()) {
                    return response()->json([
                        'success' => true,
                        'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => '¡Error!, No se pudo eliminar.' . $id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, ' . $e->getMessage(),
                ]);
            }
        }
    }
}
