<?php

namespace App\Http\Controllers;

use App\Datos;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Servicio;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ServicioFormRequest;
use App\Producto;
use Illuminate\Support\Facades\DB;

class Servicio2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
       if($request)
        {
            $query = trim ($request -> get('searchText'));
            $servicio = Producto::where('NombProducto','LIKE','%'. $query . '%')
                ->where('IdCategoria', 1)
                ->paginate(7);
            $datos_hotel = Datos::first();
          return view('almacen.registrar_servicio.index',["servicio"=>$servicio,"searchText"=>$query, "datos_hotel"=>$datos_hotel]);
          }
    }
    public function create()
    {
        return view("almacen.registrar_servicio.create");
    }
    public function store(ServicioFormRequest $request)
    {
        $servicio = new Producto;
        $servicio -> NombProducto =$request -> get ('NombProducto');
        $servicio -> Precio =$request -> get ('Precio');
        $servicio -> IdCategoria = 1;
        $servicio -> save();
        return Redirect::to('almacen/registrar_servicio')->with(['success' => 'Se agregó  el Servicio ' . $request -> get ('NombProducto') . '.']);
    }
    public function show($id)
    {
        return view("almacen.registrar_servicio.show",["servicio"=>Servicio::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("almacen.registrar_servicio.edit",["servicio"=>Producto::findOrFail($id)]);
    }
    public function update(ServicioFormRequest $request,$id)
    {
        $servicio = Producto::findOrFail($id);
        $servicio -> NombProducto =$request -> get ('NombProducto');
        $servicio -> Precio =$request -> get ('Precio');
        $servicio->update();
        return Redirect::to('almacen/registrar_servicio')->with(['success' => 'Se modificó  el Servicio ' . $request -> get ('NombProducto') . '.']);
    }
    public function destroy(Request $request, $id){
        try{
            if ( $request->ajax() ) {
                $docu   = Producto::findOrFail( $id );

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
                    'message' => '¡Error!, Este registro tiene asociado una o más Habitaciones.',
                ] );
            }

        }
    }
}
