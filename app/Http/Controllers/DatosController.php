<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Datos;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\DatoFormRequest;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
class DatosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
       if($request)
        {
            $Datos = DB::table('datos_hotel')
            ->first();
          return view('configuracion.datos_hotel.index',["Datos"=>$Datos]);
          }
    }
    public function update(DatoFormRequest $request,$id)
    {
        $Datos=Datos::findOrFail($id);
        $Datos->nombre=$request->get('Nombre');
        $Datos->direccion=$request->get('Direccion');
        $Datos->telefono=$request->get('Telefono');
        $Datos->ruc=$request->get('ruc');
        $Datos->simboloMoneda=$request->get('simboloMoneda');
        if($request->hasFile('Imagen')){
            if(!empty($Datos->logo) && file_exists(public_path('logo/' .$Datos->logo))){
                unlink(public_path('logo/' .$Datos->logo));
            }
            $file = $request->file('Imagen');
            $filename    = $file->getClientOriginalName();
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(200, 200);
            $image_resize->save(public_path('logo/' .$filename));
            $Datos -> logo=$filename;
        }
        $Datos->update();
        return Redirect::to('configuracion/datos_hotel')->with(['success' => 'Datos del Hotel modificados satisfactoriamente.']);
    }
}
