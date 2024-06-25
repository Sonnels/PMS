<?php

namespace App\Http\Controllers;

use App\Datos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VentaFormRequest;
use App\Venta;
use App\Producto;
use App\Detalleventa;
use Exception;
use Carbon\Carbon;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        if ($request) {

            $detalle_venta = DB::table('detalle_venta')
            -> get();

            $venta = DB::table('venta as v')
                ->join('cliente as c','v.IdCliente','c.IdCliente')
                ->select('v.fechaVenta','v.codVenta','v.horaVenta','v.totalVenta','v.estado','c.Nombre', 'c.Apellido', 'codCaja')
                ->Where(function ($q)  use ($query) {
                    $q->orwhere('Nombre', 'LIKE', '%' . $query . '%');
                })
                ->orderByDesc('v.codVenta')
                ->paginate(10);

            return view('ventas.otros.index', ["venta" => $venta,"detalle_venta"=>$detalle_venta,"searchText" => $query]);
        }
    }

    public function create()
    {
        $producto = DB::table('producto')
            ->where('IdCategoria', '!=', 1)
            ->get();
        $cliente = DB::table('cliente')->orderByDesc('IdCliente')->get();
        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
        $tipo_documento = DB::table('tipo_documento')->get();
        $datos_empresa = Datos::first();
        return view('ventas.otros.create', ["producto"=>$producto, "cliente" => $cliente, "caja"=>$caja, "datos_empresa"=>$datos_empresa, "tipo_documento"=>$tipo_documento]);
    }

    public function store(VentaFormRequest $request)
    {
        $caja = DB::table('caja')->where('montoCierre', null)->first();
        try{
            $IdProducto = $request->get('codProducto');
            $cantidad = $request -> get ('cantidad');
            $descuento = $request -> get ('descuento');
            $precioVenta = $request -> get ('precioVenta');

             // Inicio Calculo Stock
             $producto=DB::table('producto')->get();
             $cont_0 = 0;
             $arr = array();
             foreach($producto as $pro){
                 $arr[strval($pro->IdProducto)] = $pro->stock;
             }
             while ($cont_0 < count($IdProducto)) {
                 $arr[strval($IdProducto[$cont_0])] = $arr[strval($IdProducto[$cont_0])] - $cantidad[$cont_0];
                 if ($arr[strval($IdProducto[$cont_0])] < 0){
                     return redirect()->back()->with(['error' => 'La cantidad a vender supera el stock en unos de los productos.']);;
                 }
                 $cont_0 = $cont_0 +1;
             }
             // Fin Calculo Stock

            // DB::beginTransaction();
            $venta = new Venta;
            $venta->IdCliente =  $request->get('IdCliente');
            $venta->totalVenta = $request->get('totalVenta');
            $mytime = Carbon::now('America/Lima');
            $fecha_hora = $mytime->toDateTimeString();
            $fecha_hora1 = $mytime->toTimeString();
            $venta->fechaVenta = $fecha_hora;
            $venta->horaVenta = $fecha_hora1;
            $venta->estado = 'a';
            $venta->metodoPago = $request->get('metodoPago');
            $venta -> codCaja =  $caja -> codCaja;
            // $venta->nroCuenta = $request->get('nroCuenta');
            $venta->save();

            $cont = 0;
            while($cont < count ($IdProducto)){
                $detalle = new Detalleventa;
                $detalle -> codVenta = $venta->codVenta;
                $detalle -> IdProducto = $IdProducto[$cont];
                $detalle -> cantidad = $cantidad[$cont];
                $detalle -> descuento = $descuento[$cont];
                $detalle -> precioVenta = $precioVenta[$cont];
                $detalle -> save();

                    // Actualizamos el stock de los productos
                $produc=Producto::findOrFail($IdProducto[$cont]);
                $produc -> stock =$produc->stock - $cantidad[$cont];
                $produc->update();
                $cont = $cont+1;
            }
            return Redirect::to('ventas/otros')->with(['success' => 'Venta efectuada correctamente']);
            // DB::commit();
        }catch(Exception $e){
            // DB::rollback();
            return redirect()->back()->with(['error' =>  "Ocurrio un error <br>" . $e->getMessage()]);
        }

    }
    public function show ($id){
        $venta = DB::table('venta as v')
            ->join('cliente as c','v.IdCliente','c.IdCliente')
            ->join('detalle_venta as dv','v.codVenta','dv.codVenta')
            ->join('producto as pd','dv.IdProducto','pd.IdProducto')
            ->select('v.codVenta', 'v.fechaVenta','v.horaVenta','dv.IdProducto','v.totalVenta','v.estado','pd.stock','c.Nombre')
            ->where('v.codVenta',$id)
            ->first();
        $detalle_venta = DB::table('detalle_venta as d')
            ->join('producto as p','d.IdProducto','p.IdProducto')
            ->select('p.NombProducto','d.cantidad','d.precioVenta','d.descuento')
            ->where('d.codVenta',$id)
            -> get();
        return view("ventas.otros.show",["venta"=>$venta,"detalle_venta"=>$detalle_venta]);
    }

    public static function validate_destroy($codCaja){
        $caja = DB::table('caja')->where('codCaja', $codCaja)
        ->where('montoCierre', null)->first();

        return isset($caja) ? true : false;
    }


    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                // Inicia la transacción aquí
                return DB::transaction(function () use ($id) {
                    $docu = Venta::findOrFail($id);

                    $detalle = Detalleventa::where('codVenta', $id)->get();

                    foreach ($detalle as $d) {
                        $produc = Producto::findOrFail($d->IdProducto);
                        $produc->stock = $produc->stock + $d->cantidad;
                        $produc->update();
                    }

                    $detalle->each->delete();

                    if ($docu->delete()) {
                        // Realiza el commit de la transacción si todas las operaciones son exitosas
                        return response()->json([
                            'success' => true,
                            'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                        ]);
                    } else {
                        // Realiza el rollback si alguna operación falla
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => '¡Error!, No se pudo eliminar.',
                        ]);
                    }
                });
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                // Realiza el rollback en caso de excepción
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, ' . $e->getMessage(),
                ]);
            }
        }
    }

    public function exportPdf($id){
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        $venta = DB::table('venta as v')
            ->join('cliente as c','v.IdCliente','c.IdCliente')
            ->join('detalle_venta as dv','v.codVenta','dv.codVenta')
            ->join('producto as pd','dv.IdProducto','pd.IdProducto')
            ->select('v.codVenta', 'v.fechaVenta','v.horaVenta','dv.IdProducto','v.totalVenta','v.estado','pd.stock','c.Nombre')
            ->where('v.codVenta',$id)
            ->first();
        $detalle_venta = DB::table('detalle_venta as d')
            ->join('producto as p','d.IdProducto','p.IdProducto')
            ->select('p.NombProducto','d.cantidad','d.precioVenta','d.descuento')
            ->where('d.codVenta',$id)
            -> get();
        $empresa = DB::table('datos_hotel')->first();

        $pdf = \PDF::loadView('ventas/otros.report', ["venta"=>$venta, "detalle_venta"=>$detalle_venta, "empresa"=>$empresa, "fechaHora"=>$fechaHora])
        ->setPaper('b7', 'portrait');
        return $pdf->stream('Venta #' . $venta->codVenta .'.pdf');
    }

    public function listPdf($id){

        $id=$id=='TODO'?'':$id;
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $fecha_hora = $mytime->toDateTimeString();

        $venta = DB::table('venta as v')
        ->join('cliente as c','v.IdCliente','c.IdCliente')
        ->select('v.codVenta', 'v.fechaVenta','v.horaVenta','v.totalVenta','v.estado','c.Nombre')
        ->Where(function ($q)  use ($id) {
            $q->orwhere('c.Nombre', 'LIKE', '%' . $id . '%');
        })->get();

        $empresa = DB::table('datos_hotel')->first();

        $pdf = \PDF::loadView('ventas/otros.list', ["venta"=>$venta,  "id"=>$id, "fecha_hora"=>$fecha_hora, "empresa"=>$empresa]);
        // ->setPaper('a4', 'landscape');
        return $pdf->stream();

    }
}
