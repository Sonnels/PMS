<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UsuarioFormRequest;
use App\Http\Requests\Usuario2FormRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UsuarioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request){

        if ($request){

            $query=trim($request->get('searchText'));
            $usuario=DB::table('usuario')->where('Nombre','LIKE','%'.$query.'%')
            ->orwhere('NumDocumento','LIKE','%'.$query.'%')
            ->orwhere('Estado','LIKE','%'.$query.'%')
            ->orderBy('IdUsuario','desc')
            ->paginate(7);
            return view('acceso.usuario.index',["usuario"=>$usuario, "searchText"=>$query]);
        }
    }

    public function create(){
        return view ("acceso.usuario.create", ["tipo"=>['ADMINISTRADOR', 'RECEPCIONISTA']]);
    }

    public function store(UsuarioFormRequest $request){
        $usuario = new User;
        $usuario->Nombre=strtoupper($request->get('Nombre'));
        $usuario->NumDocumento=$request->get('NumDocumento');
        $usuario->password=bcrypt($request->get('password'));
        $usuario->Celular=$request->get('Celular');
        $usuario->email=$request->get('email');
        $usuario->tipo=$request->get('tipo');
        $usuario->Estado='ACTIVO';
        $usuario->save();
        return Redirect::to('acceso/usuario')->with(['success' => 'Se agregó al usuario ' . $usuario->Nombre . '.']);
    }

    public function edit($id){
        return view("acceso.usuario.edit",["usuario"=>User::findOrFail($id), "tipo"=>['ADMINISTRADOR', 'RECEPCIONISTA']]);
    }

    public function update(UsuarioFormRequest $request, $id){
        $usuario=User::findOrFail($id);
        $usuario->Nombre=strtoupper($request->get('Nombre'));
        $usuario->NumDocumento=$request->get('NumDocumento');
        if($request->get('password') != ''){
            $usuario->password=bcrypt($request->get('password'));
        }
        $usuario->Celular=$request->get('Celular');
        $usuario->email=$request->get('email');
        $usuario->tipo=$request->get('tipo');
        $usuario->update();
        return Redirect::to('acceso/usuario')->with(['success' => 'Se modificó los datos del usuario ' . $usuario->Nombre . '.']);
    }

    public function show($id){
        $n_id = substr($id, 1);

        $vuser=DB::table('usuario')
        ->where('IdUsuario','=', $n_id)
        ->first();
        if (isset($vuser->Estado)){
            if($vuser->Estado=='ACTIVO'){
                $estado = "INACTIVO";
            }else{
                $estado = "ACTIVO";
            }
        }

        $usuario=User::findOrFail($n_id);
        $usuario->Estado=$estado;
        $usuario->update();
        return Redirect::to('acceso/usuario')->with(['success' => 'El estado del usuario ' . $usuario->Nombre . ' fue cambiado.']);
    }

    public function destroy(Request $request, $id){
        try{
            if ( $request->ajax() ) {
                $docu   = User::findOrFail( $id );

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
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros.',
                ] );
            }

        }
    }

}
