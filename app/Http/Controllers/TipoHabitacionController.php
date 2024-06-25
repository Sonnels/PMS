<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\TipoHabitacion;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\TipoHabitacionFormRequest;
use Illuminate\Support\Facades\DB;


class TipoHabitacionController extends Controller
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
            $TipoHabitacion = DB::table('tipohabitacion')->where('Denominacion','LIKE','%'.$query.'%')
            ->orderBy('IdTipoHabitacion','desc')
            ->paginate(7);
          return view('mantenimiento.tipo_habitacion.index',["TipoHabitacion"=>$TipoHabitacion,"searchText"=>$query]);
          }
    }
    public function create()
    {
        return view("mantenimiento.tipo_habitacion.create");
    }
    public function store(TipoHabitacionFormRequest $request)
    {
        $TipoHabitacion = new TipoHabitacion;
        $TipoHabitacion -> Denominacion =$request -> get ('Denominacion');
        $TipoHabitacion -> Descripcion =$request -> get ('Descripcion');
        $TipoHabitacion -> precioHora =$request -> get ('precioHora');
        $TipoHabitacion -> precioHora6 =$request -> get ('precioHora6');
        $TipoHabitacion -> precioHora8 =$request -> get ('precioHora8');
        $TipoHabitacion -> precioNoche =$request -> get ('precioNoche');
        $TipoHabitacion -> precioMes =$request -> get ('precioMes');
        $TipoHabitacion -> save();
        return Redirect::to('mantenimiento/tipo_habitacion')->with(['success' => 'Se agregó el tipo de habitación ' . $request -> get ('Denominacion')]);
    }
    public function show($id)
    {
        return view("mantenimiento.tipo_habitacion.show",["TipoHabitacion"=>TipoHabitacion::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("mantenimiento.tipo_habitacion.edit",["TipoHabitacion"=>TipoHabitacion::findOrFail($id)]);
    }
    public function update(TipoHabitacionFormRequest $request,$id)
    {
        $TipoHabitacion=TipoHabitacion::findOrFail($id);
        $TipoHabitacion->Denominacion=$request->get('Denominacion');
        $TipoHabitacion->Descripcion=$request -> get ('Descripcion');
        $TipoHabitacion -> precioHora =$request -> get ('precioHora');
        $TipoHabitacion -> precioHora6 =$request -> get ('precioHora6');
        $TipoHabitacion -> precioHora8 =$request -> get ('precioHora8');
        $TipoHabitacion -> precioNoche =$request -> get ('precioNoche');
        $TipoHabitacion -> precioMes =$request -> get ('precioMes');
        $TipoHabitacion->update();
        return Redirect::to('mantenimiento/tipo_habitacion')->with(['success' => 'Se modificó los datos del tipo de habitación ' .  $request->get('Denominacion')]);
    }
    public function destroy(Request $request, $id){
        try{
            if ( $request->ajax() ) {
                $docu   = TipoHabitacion::findOrFail( $id );

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
