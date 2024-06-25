<?php

namespace App\Http\Controllers;

use App\Datos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\IngresoCaja;
use Exception;

class IngresoCajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));

        if ($request) {
            $val_aux = auth()->user()->tipo == 'ADMINISTRADOR';
            $ingreso = DB::table('ingreso_caja as i')->join('usuario as u', 'i.codUsuario', 'u.IdUsuario')
                ->where('codUsuario', $val_aux ? '!=' : '=', $val_aux ? '-1' : auth()->user()->IdUsuario)
                ->where('motivo','NOT LIKE', 'ALQUILER' .'%')
                ->where('motivo','NOT LIKE', 'PENALIDAD' .'%')
                ->Where(function ($q)  use ($query) {
                    $q->orwhere('recibidoDe', 'LIKE', '%' . $query . '%')
                    ->orwhere('motivo', 'LIKE', '%' . $query . '%')
                    ->orwhere('Nombre', 'LIKE', '%' . $query . '%')
                    ->orwhere('importe', 'LIKE', '%' . $query . '%');
                })
                // ->where('montoCierre', null)
                ->orderByDesc('codIngreso')
                ->paginate(10);

            $estado = ['APROBADO', 'ANULADO'];
            $mPago = ['EFECTIVO', 'B. DIGITAL', 'TARJETA'];
            $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
            $datos_empresa = Datos::first();
            return view('caja.ingreso.index', ["ingreso" => $ingreso, "estado"=>$estado, "caja" => $caja, "mPago" => $mPago,
             "searchText" => $query, "datos_empresa"=>$datos_empresa]);
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
                $ingreso = new IngresoCaja;
                $ingreso->horaIngreso =  $hora;
                $ingreso->fechaIngreso = $fecha;
                $ingreso->recibidoDe = $request->get('recibidoDe');
                $ingreso->motivo = $request->get('motivo');
                $ingreso->importe = $request->get('importe');
                $ingreso->estado = 'APROBADO';
                $ingreso->codUsuario = auth()->user()->IdUsuario;
                $ingreso->metodoPago = $request->get('metodoPago');
                $ingreso->metodoPago = 'EFECTIVO';
                $ingreso->codCaja =  $caja -> codCaja;
                $ingreso->save();
                return Redirect::to('caja/ingreso')->with(['success' => '¡Satisfactorio!, Ingreso Extra añadido.']);

            }else{
                return Redirect::to('caja/ingreso')->with(['error' => '¡Error!, La caja no se encuentra aperturada']);
            }

        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = IngresoCaja::findOrFail($id);
                // $docu->estado ='ANULADO';
                if ($docu->delete()) {
                    return response()->json([
                        'success' => true,
                        'message' => '¡Satisfactorio!, Ingreso Extra eliminado con éxito.',
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
    public static function validate_destroy($id){
        $caja = DB::table('caja')->where('codCaja', $id)
            ->where('montoCierre', null)->first();

        return isset($caja) ? true : false;
    }
}
