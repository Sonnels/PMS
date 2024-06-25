<?php

namespace App\Http\Controllers;

use App\Datos;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Producto;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ProductoFormRequest;
use App\Http\Requests\ProductoEditFormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $Producto = DB::table('producto as a')
                ->join('categoria as c', 'a.IdCategoria', '=', 'c.IdCategoria')
                ->select(
                    'a.IdProducto',
                    'a.NombProducto',
                    'a.Imagen',
                    'a.Precio',
                    'a.stock',
                    'a.Descripcion',
                    'c.Denominacion as Denominacionc',
                )
                ->where('Denominacion', '!=', 'Servicio')
                ->Where(function ($q)  use ($query) {
                    $q->orWhere('a.NombProducto', 'LIKE', '%' . $query . '%')
                        ->orWhere('c.Denominacion', 'LIKE', '%' . $query . '%');
                })
                ->orderBy('c.Denominacion')
                ->orderBy('a.NombProducto')
                ->paginate(10);
            $datos_hotel = Datos::first();
            return view('almacen.producto.index', ["Producto" => $Producto, "searchText" => $query, "datos_hotel"=>$datos_hotel]);
        }
    }
    public function create()
    {
        $Categoria = DB::table('categoria')
            ->where('IdCategoria', '!=', 1)
            ->get();
        return view("almacen.producto.create", ["Categoria" => $Categoria]);
    }
    public function store(ProductoFormRequest $request)
    {
        $Producto = new Producto;
        $Producto->NombProducto = $request->get('NombProducto');
        if ($request->hasFile('Imagen')) {
            $file = $request->file('Imagen');
            $file->move(public_path() . '/Imagenes/Productos/', $file->getClientOriginalName());
            $Producto->Imagen = $file->getClientOriginalName();
        }
        $Producto->Precio = $request->get('Precio');
        $aux_nombre_i = $request->get('nombre_imagen');
        $Producto->Descripcion = $request->get('Descripcion');
        $Producto->IdCategoria = $request->get('IdCategoria');
        $Producto->stock = $request->get('stock');
        $Producto->save();
        return Redirect::to('almacen/producto')->with(['success' => $Producto->NombProducto . ' agregado correctamente.']);
    }
    public function show($id)
    {
        return view("almacen.producto.show", ["Producto" => Producto::findOrFail($id)]);
    }
    public function edit($id)
    {
        $Producto = Producto::findOrFail($id);
        $Categoria = DB::table('categoria')
            ->where('IdCategoria', '!=', 1)
            ->get();
        return view("almacen.producto.edit", ["Producto" => $Producto, "Categoria" => $Categoria]);
    }
    public function update(ProductoEditFormRequest $request, $id)
    {
        $Producto = Producto::findOrFail($id);
        $Producto->NombProducto = $request->get('NombProducto');
        if ($request->hasFile('Imagen')) {
            $file = $request->file('Imagen');
            $file->move(public_path() . '/Imagenes/Productos/', $file->getClientOriginalName());
            $Producto->imagen = $file->getClientOriginalName();
        }
        $aux_nombre_i = $request->get('nombre_imagen');
        $Producto->Precio = $request->get('Precio');
        $Producto->Descripcion = $request->get('Descripcion');
        $Producto->IdCategoria = $request->get('IdCategoria');
        $Producto->stock = $request->get('stock');
        $Producto->update();
        return Redirect::to('almacen/producto')->with(['success' => $Producto->NombProducto . ' modificado correctamente.']);
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu   = Producto::findOrFail($id);

                if ($docu->delete()) {
                    return response()->json([
                        'success' => true,
                        'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
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
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros de Productos.',
                ]);
            }
        }
    }
    public function producto_pdf($query)
    {
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        $datos_hotel = DB::table('datos_hotel')->first();
        $query = $query == 'TODO' ? '' : $query;
        $producto = DB::table('producto as a')
            ->join('categoria as c', 'a.IdCategoria', '=', 'c.IdCategoria')
            ->select(
                'a.IdProducto',
                'a.NombProducto',
                'a.Imagen',
                'a.Precio',
                'a.stock',
                'a.Descripcion',
                'c.Denominacion as Denominacionc',
            )
            ->where('a.NombProducto', 'LIKE', '%' . $query . '%')
            ->orwhere('c.Denominacion', 'LIKE', '%' . $query . '%')
            ->orderBy('c.Denominacion')
            ->orderBy('a.NombProducto')
            ->get();

        $caja = DB::table('caja')->where('montoCierre', null)->first();

        $pdf = \PDF::loadView('almacen.producto.list', ["datos_hotel" => $datos_hotel, "producto" => $producto,
        "fechaHora" => $fechaHora, "caja"=> isset($caja) ? $caja : false]);
        // ->setPaper('a4', 'landscape');
        return $pdf->stream('Estado Inventario' . '.pdf');
    }

    public static  function contar_productos($id)
    {
        $caja = DB::table('caja')->where('montoCierre', null)->first();

        if (isset($caja)) {
            $consumo = DB::table('consumo as c')
                ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
                ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
                ->select(DB::raw('SUM(Cantidad) as Cantidad'))
                ->where('codCaja', $caja->codCaja)
                ->where('c.IdProducto', $id)
                // ->groupBy('c.IdProducto')
                ->first();

            $producto = DB::table('detalle_venta as dv')
                ->join('venta as v', 'dv.codVenta', 'v.codVenta')
                ->join('producto as p', 'dv.IdProducto', 'p.IdProducto')
                ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
                ->select(DB::raw('SUM(dv.Cantidad) as Cantidad'))
                ->where('codCaja', $caja->codCaja)
                ->where('dv.IdProducto', $id)
                ->first();

            $total = $consumo->Cantidad + $producto->Cantidad;
            return $total;
        }

        return false;
    }
}
