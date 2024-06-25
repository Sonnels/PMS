<?php

namespace App\Http\Controllers;

use App\Datos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Egreso;
use Exception;

class EgresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        $query2 = trim($request->get('searchText2'));

        if ($request) {
            $val_aux = auth()->user()->tipo == 'ADMINISTRADOR';
            $egreso = DB::table('egreso_caja as e')->join('usuario as u', 'e.codUsuario', 'u.IdUsuario')
                ->select('codEgreso', 'horaEgreso', 'fechaEgreso', 'e.tipo', 'entregadoA', 'motivo', 'importe', 'e.estado', 'Nombre', 'codCaja')
                ->where('codUsuario', $val_aux ? '!=' : '=', $val_aux ? '-1' : auth()->user()->IdUsuario)
                ->where('e.tipo', 'LIKE', '%' . $query . '%')
                // ->where('e.estado', 'LIKE', '%' . $query2 . '%')
                ->Where(function ($q)  use ($query2) {
                    $q->orwhere('entregadoA', 'LIKE', '%' . $query2 . '%')
                        ->orwhere('motivo', 'LIKE', '%' . $query2 . '%')
                        ->orwhere('Nombre', 'LIKE', '%' . $query2 . '%')
                        ->orwhere('importe', 'LIKE', '%' . $query2 . '%');
                })
                ->orderByDesc('codEgreso')
                ->paginate(10);

            $estado = ['APROBADO', 'ANULADO'];
            $tipo = ['Compras', 'Servicios', 'Remuneraciones', 'Otros'];
            $caja = DB::table('caja')->where('montoCierre', null)->first();
            $datos_empresa = Datos::first();
            return view('caja.egreso.index', ["egreso" => $egreso, "estado" => $estado, "tipo" => $tipo, "caja" => $caja,
                "searchText" => $query, "searchText2" => $query2, "datos_empresa"=>$datos_empresa
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $mytime = Carbon::now('America/Lima');
            $hora = $mytime->toTimeString();
            $fecha = $mytime->toDateString();
            $caja = DB::table('caja')->where('montoCierre', null)->first();
            if ($caja->codCaja != null) {
                $ingreso = new Egreso();
                $ingreso->horaEgreso =  $hora;
                $ingreso->fechaEgreso = $fecha;
                $ingreso->tipo = $request->get('tipo');
                $ingreso->entregadoA = $request->get('entregadoA');
                $ingreso->motivo = $request->get('motivo');
                $ingreso->importe = $request->get('importe');
                $ingreso->estado = 'APROBADO';
                $ingreso->codUsuario = auth()->user()->IdUsuario;
                $ingreso->codCaja =  $caja->codCaja;
                $ingreso->save();
                return Redirect::to('caja/egreso')->with(['success' => '¡Satisfactorio!, Egreso registrado.']);
            } else {
                return Redirect::to('caja/egreso')->with(['error' => '¡Error!, La caja no se encuentra aperturada']);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu = Egreso::findOrFail($id);

                if ($docu->delete()) {
                    return response()->json([
                        'success' => true,
                        'message' => '¡Satisfactorio!, Egreso eliminado con éxito.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => '¡Error!, No se pudo eliminar.',
                    ]);
                }
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros.',
                ]);
            }
        }
    }
}
