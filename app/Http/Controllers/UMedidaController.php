<?php

namespace App\Http\Controllers;

use App\Http\Requests\UMedidaFormRequest;
use App\UMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UMedidaController extends Controller
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
            $unidad_medida = UMedida::where('nombreUM','LIKE','%'. $query . '%')->paginate(7);
          return view('configuracion.unidad_medida.index',["unidad_medida"=>$unidad_medida,"searchText"=>$query]);
          }
    }
    public function create()
    {
        return view("configuracion.unidad_medida.create");
    }
    public function store(UMedidaFormRequest $request)
    {
        $unidad_medida = new UMedida;
        $unidad_medida -> nombreUM =$request -> get ('nombreUM');
        $unidad_medida -> valorUM =$request -> get ('valorUM');
        $unidad_medida -> save();
        return Redirect::to('configuracion/unidad_medida')->with(['success' => 'Se agregó  la U. Medida ' . $request -> get ('nombreUM') . '.']);
    }

    public function show($id)
    {
        return view("configuracion.unidad_medida.show",["unidad_medida"=>UMedida::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("configuracion.unidad_medida.edit",["unidad_medida"=>UMedida::findOrFail($id)]);
    }

    public function update(UMedidaFormRequest $request,$id)
    {
        $unidad_medida = UMedida::findOrFail($id);
        $unidad_medida -> nombreUM =$request -> get ('nombreUM');
        $unidad_medida -> valorUM =$request -> get ('valorUM');
        $unidad_medida->update();
        return Redirect::to('configuracion/unidad_medida')->with(['success' => 'Se modificó  la U. Medida ' . $request -> get ('nombreUM') . '.']);
    }

    public function destroy(Request $request, $id){
        try{
            if ( $request->ajax() ) {
                $docu   = UMedida::findOrFail( $id );

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
                    'message' =>  $e->getMessage(),
                ] );
            }

        }
    }
}
