<?php

namespace App\Http\Controllers;

use App\Consumo;
use App\Habitacion;
use App\Http\Requests\Pago2Request;
use App\Pago2;
use App\Reserva;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class Pago2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $paginate = 10;
        $searchText = $request->get('searchText');
        $registro = DB::table('pagos as p')->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->join('cliente as c', 'r.IdCliente', 'c.IdCliente')
            ->orderByDesc('idPagos')
            ->paginate($paginate);

        return view('caja.pago.index', compact("registro", "paginate", "searchText"));
    }

    public function create()
    {
        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
        $habitacion = DB::table('reserva as r')
            ->join('habitacion as h', 'r.Num_Hab', 'h.Num_Hab')
            ->join('cliente as c', 'r.IdCliente', 'c.IdCliente')
            ->where('r.Estado', 'HOSPEDAR')->orderBy('h.Num_Hab')->get();
        $consumo = DB::table('consumo as c')->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
            ->get();
        $alquiler = DB::table('pago as p')->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->select('p.IdReserva', 'CostoAlojamiento', 'descuento', 'TotalPago')->get();

        $renovacion = DB::table('renovacion')->select(DB::raw('SUM(cosRen) - SUM(descuentoRen) as total'), 'IdReserva')
            ->groupBy('IdReserva')
            ->get();
        $pago = DB::table('pagos')->select(DB::raw('SUM(monPag) as total'), 'IdReserva')
            ->groupBy('IdReserva')
            ->get();
        $metPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'];
        return view('caja.pago.create', compact("caja", "habitacion", "consumo", "alquiler", "renovacion", "pago", "metPago"));
    }

    public function store(Pago2Request $request)
    {
        $caja = DB::table('caja')->where('montoCierre', null)->first();
        try {
            $myTime = Carbon::now('America/Lima');
            $registro = new Pago2();
            $registro->fecPag = $myTime->toDateTimeString();
            $registro->motPag = $request->get('motPag');
            $registro->metPag = $request->get('metPag');
            $registro->desPag = empty($request->get('desPag')) ? 0 : $request->get('desPag');
            $registro->monPag = $request->get('monPag');
            $registro->IdReserva = $request->get('IdReserva');
            $registro->codCaja = $caja->codCaja;
            $registro->save();
            return Redirect::to('caja/pago')->with(['success' => '¡Satisfactorio!, Pago N° ' . $registro->idPagos . ' registrado.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function pagar_consumo($id, $metodoPago)
    {
        $mytime = Carbon::now('America/Lima');
        $caja = DB::table('caja')->where('montoCierre', null)->first();
        try {
            $registro  = Consumo::findOrFail($id);
            $registro->FechaPago = $mytime->toDateTimeString();
            $registro->Estado = 'PAGADO';
            $registro->metodoPago = $metodoPago;
            $registro->codCaja = $caja->codCaja;
            $registro->update();
            return redirect()->back()->with(['id' => $registro->IdReserva,
                'success' => '¡Satisfactorio!, Pago registrado.']);
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function destroy(Request $request, $id){
        try{
            if ( $request->ajax() ) {
                $docu   = Pago2::findOrFail( $id );

                if ( $docu->delete() ) {
                    return response()->json( [
                        'success' => true,
                        'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                    ] );
                } else {
                    return response()->json( [
                        'success' => false,
                        'message' => '¡Error!, No se pudo eliminar.',
                    ] );
                }
            }
        }catch(\Exception $e){
            if ( $request->ajax() ) {
                return response()->json( [
                    'success' => false,
                    'message' => '¡Error!, ' . $e->getMessage(),
                ] );
            }

        }
    }

    public static function validate_destroy($id, $id2){
        $caja = DB::table('caja')->where('codCaja', $id)
            ->where('montoCierre', null)->first();
        $alquiler = Reserva::where('IdReserva', $id2)->first();
        return isset($caja) && $alquiler->Estado == 'HOSPEDAR' ? true : false;
    }

}
