<?php

namespace App\Http\Controllers;

use App\Datos;
use App\Pago;
use App\Renovacion;
use App\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LRenovacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //

    public function index (Request $request){
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();

        $paginate = 8;
        $searchText = empty($request->get('searchText')) ? date('Y-m-01', strtotime($fecha)) : $request->get('searchText');
        $searchText2 = empty($request->get('searchText2')) ? date('Y-m-t', strtotime($fecha)) : $request->get('searchText2');
        $searchText3 = trim($request->get('searchText3'));
        if ($request) {
            $renovacion = DB::table('renovacion as ren')
                ->join('reserva as res', 'ren.IdReserva', 'res.IdReserva')
                ->join('cliente as c', 'res.IdCliente', 'c.IdCliente')
                ->whereBetween('fRenovacion', [$searchText . ' 00:00:01', $searchText2 . ' 23:59:59'])
                ->Where(function ($q)  use ($searchText3) {
                    $q->orWhere('Num_Hab', 'LIKE', '%' . $searchText3 . '%')
                        ->orWhere('Nombre', 'LIKE', '%' . $searchText3 . '%')
                        ->orWhere('NumDocumento', 'LIKE', '%' . $searchText3 . '%')
                        ->orWhere('codCaja', 'LIKE', '%' . $searchText3 . '%');
                })
                ->orderByDesc('idRenovacion')
                ->paginate($paginate);
            return view('reserva.listar-renovacion.index', compact("renovacion", "paginate", "searchText", "searchText2", "searchText3"));
        }
    }

    public static function get_last_ren($idReserva, $idRenovacion){
        if (Reserva::findOrFail($idReserva)->Estado == 'H. CULMINADO') {
            return false;
        }

        $renovacion = Renovacion::where('IdReserva', $idReserva)->orderByDesc('idRenovacion')->first();
        return $renovacion->idRenovacion == $idRenovacion ? true : false;
    }

    public function show ($id){
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();

        $renovacion = DB::table('renovacion as ren')
            ->join('reserva as res', 'ren.IdReserva', 'res.IdReserva')
            ->join('cliente as c', 'res.IdCliente', 'c.IdCliente')
            ->join('caja as ca', 'ren.codCaja', 'ca.codCaja')
            ->join('usuario as u', 'ca.codUsuario', 'u.IdUsuario')
            ->join('habitacion as h', 'res.Num_Hab', 'h.Num_Hab')
            ->join('tipohabitacion as th', 'h.IdTipoHabitacion', 'th.IdTipoHabitacion')
            ->select(
                'res.IdReserva',
                'ren.idRenovacion',
                'res.IdCliente',
                'fIniRen',
                'fFinRen',
                'tarRen',
                'canRen',
                'metPagRen',
                'cosRen',
                'c.NumDocumento as Ndcliente',
                'Observacion',
                'res.Estado as EsReser',
                'c.Celular',
                'c.Direccion',
                'res.Num_Hab',
                'u.NumDocumento',
                'u.Nombre',
                'th.Denominacion',
                'c.Nombre as nomcli',
            )
            ->where('idRenovacion', $id)
            ->first();

        $datos_empresa = Datos::first();

        $pdf = \PDF::loadView('reserva.listar-renovacion.show', ["renovacion"=>$renovacion, "datos_empresa" => $datos_empresa, "fecha_actual" => $fecha])
        ->setPaper(array(0, 0, 204, 450));
        return $pdf->stream();

    }

    public function destroy(Request $request, $id){

        try{
            if ( $request->ajax() ) {
                DB::beginTransaction();
                try {
                    //code...
                    $renovacion = Renovacion::findOrFail($id);
                    $pago = Pago::where('IdReserva', $renovacion->IdReserva)->first();
                    $pago->departure_date = $renovacion->fIniRen;
                    $pago->update();
                    $renovacion->delete();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json( [
                        'success' => false,
                        'message' => '¡Error!, No se pudo eliminar.',
                    ] );
                }

                return response()->json( [
                    'success' => true,
                    'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                ] );
            }
        }catch(\Exception $e){

            if ( $request->ajax() ) {
                return response()->json( [
                    'success' => false,
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros.',
                ] );
            }

        }
    }
}
