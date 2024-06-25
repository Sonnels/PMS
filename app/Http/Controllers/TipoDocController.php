<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoDocFormRequest;
use App\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TipoDocController extends Controller
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
            $tipo_documento = TipoDocumento::where('nomTipDoc','LIKE','%'. $query . '%')->paginate(7);
          return view('configuracion.tipo_documento.index',["tipo_documento"=>$tipo_documento,"searchText"=>$query]);
          }
    }
    public function create()
    {
        return view("configuracion.tipo_documento.create");
    }
    public function store(TipoDocFormRequest $request)
    {
        $tipo_documento = new TipoDocumento;
        $tipo_documento -> nomTipDoc =$request -> get ('nomTipDoc');
        $tipo_documento -> longitud =$request -> get ('longitud');
        $tipo_documento -> save();
        return Redirect::to('configuracion/tipo_documento')->with(['success' => 'Se agregó  el Tipo de Documento ' . $request -> get ('nomTipDoc') . '.']);
    }
    public function show($id)
    {
        return view("configuracion.tipo_documento.show",["tipo_documento"=>TipoDocumento::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("configuracion.tipo_documento.edit",["tipo_documento"=>TipoDocumento::findOrFail($id)]);
    }
    public function update(TipoDocFormRequest $request,$id)
    {
        $tipo_documento = TipoDocumento::findOrFail($id);
        $tipo_documento -> nomTipDoc =$request -> get ('nomTipDoc');
        $tipo_documento -> longitud =$request -> get ('longitud');
        $tipo_documento->update();
        return Redirect::to('configuracion/tipo_documento')->with(['success' => 'Se modificó  el Tipo de Documento ' . $request -> get ('nomTipDoc') . '.']);
    }
    public function destroy(Request $request, $id){
        try{
            if ( $request->ajax() ) {
                $docu   = TipoDocumento::findOrFail( $id );

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
