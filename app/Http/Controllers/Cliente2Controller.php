<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Cliente;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ClienteFormRequest;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class Cliente2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

    }
    public function create()
    {


    }
    public function store(ClienteFormRequest $request)
    {
        $cliente = new Cliente;
        $cliente -> Nombre =$request->get ('Nombre');
        $cliente ->Apellido =$request -> get ('Apellido');
        $cliente ->Celular =$request -> get ('Celular');
        $cliente ->Correo =$request -> get ('Correo');
        $tipo_documento = explode('_', $request->get('TipDocumento'));
        $cliente->TipDocumento = $tipo_documento[0];
        $cliente ->NumDocumento =$request -> get ('NumDocumento');
        $cliente ->Direccion =$request -> get ('Direccion');
        $cliente ->nroMatricula =$request -> get ('nroMatricula');
        // $img = $request -> get ('fotocamara');
        // $img = str_replace('data:image/png;base64,', '', $img);
        // $img = str_replace(' ', '+', $img);
        // $image = base64_decode($img);
        // $extension="png";
        // $filename=$request -> get ('NumDocumento').date('h-i-s'). date('m-d') . '.'.$extension;
        // $cliente -> captura = $filename;
        // Image::make($image)->save(public_path("Imagenes/cliente"."/".$filename));

        $cliente -> save();
        // return Redirect::to('reserva/registro/'. $num_hab .'/create');
        return redirect()->back()->with(["success" => 'Se agregó un nuevo Cliente']);
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $Cliente =Cliente::findOrFail($id);
        return view("reserva.clientes.edit",["Cliente"=>$Cliente]);
    }
    public function update(ClienteFormRequest $request,$id)
    {

    }
    public function destroy(Request $request, $id){

    }
}
