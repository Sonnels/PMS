<?php

namespace App\Http\Controllers;

use App\Datos;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\IngresoFormRequest;
use App\Ingreso;
use App\Producto;
use App\DetalleIngreso;
use App\Exports\CompraList;
use App\Exports\CompraListDetail;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');

        $start = date('Y-m-01', strtotime($mytime->toDateString()));
        $end = date('Y-m-t', strtotime($mytime->toDateString()));

        $paginate = 15;
        if ($request) {
            $query = trim($request->get('searchText'));
            $query2 = trim($request->get('searchText2'));

            $query = empty($query) ? $start : $query;
            $query2 = empty($query2) ? $end : $query2;

            $ingresos = DB::table('ingreso as i')
                ->join('proveedor as p', 'i.idpro', '=', 'p.idpro')
                ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
                ->select('i.idingreso', 'i.fecha', 'i.hora', 'p.nomPro', DB::raw('sum(di.cantidad*precioCompra) as total'))
                ->whereBetween('fecha', [$query, $query2])
                ->orderBy('i.idingreso', 'desc')
                ->groupBy('i.idingreso', 'i.fecha', 'i.hora', 'p.nomPro')
                ->paginate($paginate);

            return view('compras.ingreso_producto.index', ["ingresos" => $ingresos, "searchText" => $query, "searchText2" => $query2, "paginate" => $paginate]);
        }
    }

    public function create()
    {
        $personas = DB::table('proveedor')->where('idpro', '!=', '1')->orderByDesc('idpro')->get();
        $articulos = DB::table('producto as art')
            ->select(DB::raw('CONCAT(art.NombProducto) as articulo'), 'art.IdProducto', 'art.stock')
            ->where('IdCategoria', '!=', 1)
            ->get();
        $unidadMedida = DB::table('unidad_medida')->orderBy('valorUM')->get();
        $datos_empresa = Datos::first();
        return view("compras.ingreso_producto.create", ["personas" => $personas, "articulos" => $articulos, "unidadMedida" => $unidadMedida, "datos_empresa" => $datos_empresa]);
    }

    public function store(IngresoFormRequest $request)
    {

        try {
            DB::beginTransaction();
            $ingreso = new Ingreso;
            $ingreso->idpro = $request->get('idproveedor');
            $ingreso->IdUsuario = auth()->user()->IdUsuario;
            // $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
            // $ingreso->serie_comprobante=$request->get('serie_comprobante');
            // $ingreso->num_comprobante=$request->get('num_comprobante');
            $mytime = Carbon::now('America/Lima');
            $ingreso->fecha = $mytime->toDateString();
            $ingreso->hora = $mytime->toTimeString();
            // $ingreso->impuesto='18';
            // $ingreso->estado='A';
            $ingreso->save();

            $idarticulo = $request->get('idarticulo');
            $uMedida = $request->get('unidadMedida');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            // $precio_venta = $request->get('precio_venta');

            $cont = 0;

            while ($cont < count($idarticulo)) {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->idingreso;
                $detalle->IdProducto = $idarticulo[$cont];
                $detalle->valorUMedida = $uMedida[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precioCompra = $precio_compra[$cont];
                // $detalle->precioVenta = $precio_venta[$cont];
                $detalle->save();

                $produc = Producto::findOrFail($idarticulo[$cont]);
                $produc->stock = $produc->stock + ($cantidad[$cont] * $uMedida[$cont]);
                $produc->update();

                $cont = $cont + 1;
            }

            DB::commit();
            return Redirect::to('compras/ingreso_producto')->with(['success' => 'Ingreso agregado correctamente.']);
        } catch (\Exception $e) {
            DB::rollback();
            return Redirect::to('compras/ingreso_producto')->with(['error' =>  $e->getMessage()]);
        }
    }
    public function show($id)
    {
        $ingreso = DB::table('ingreso as i')
            ->join('proveedor as p', 'i.idpro', 'p.idpro')
            ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
            ->select('p.nomPro', DB::raw('sum(di.cantidad*precioCompra) as total'))
            ->groupBy('i.idingreso', 'p.nomPro')
            ->where('i.idingreso', $id)
            ->first();
        $detalles = DB::table('detalle_ingreso as di')
            ->join('producto as p', 'p.IdProducto', 'di.IdProducto')
            ->select('p.NombProducto', 'di.cantidad', 'di.valorUMedida', 'di.precioCompra')
            ->where('di.idingreso', $id)
            ->get();
        return view("compras.ingreso_producto.show", ["ingreso" => $ingreso, "detalles" => $detalles]);
    }

    // public function destroy($id)
    // {
    //     $ingreso = Ingreso::findOrFail($id);
    //     $ingreso->Estado = 'C';
    //     $ingreso->update();
    //     return Redirect::to('compras/ingreso_producto');
    // }

    public function list_compra($query, $query2)
    {
        $ingresos = DB::table('ingreso as i')
            ->join('proveedor as p', 'i.idpro', '=', 'p.idpro')
            ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
            ->select('i.idingreso', 'i.fecha', 'i.hora', 'p.nomPro', DB::raw('sum(di.cantidad*precioCompra) as total'))
            ->whereBetween('fecha', [$query, $query2])
            ->orderBy('i.idingreso', 'desc')
            ->groupBy('i.idingreso', 'i.fecha', 'i.hora', 'p.nomPro')
            ->get();

        $datos_hotel = DB::table('datos_hotel')->first();
        $pdf = \PDF::loadView('compras/ingreso_producto/listPdf', ["ingresos" => $ingresos, "inicio" => $query, "fin" => $query2, "datos_hotel" => $datos_hotel]);
        return $pdf->stream();
    }

    public function list_compraE($f1, $f2)
    {
        return Excel::download(new CompraList($f1, $f2), 'Listado de Compras.xlsx');
    }

    public function list_compraDetalladoE($f1, $f2)
    {
        return Excel::download(new CompraListDetail($f1, $f2), 'Listado de Compras Detallado.xlsx');
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                // Inicia la transacción aquí
                return DB::transaction(function () use ($id) {
                    $docu = Ingreso::findOrFail($id);

                    $detalle = DetalleIngreso::where('idingreso', $id)->get();

                    foreach ($detalle as $d) {
                        $produc = Producto::findOrFail($d->IdProducto);
                        $produc->stock = $produc->stock - ($d->cantidad * $d->valorUMedida);
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
}
