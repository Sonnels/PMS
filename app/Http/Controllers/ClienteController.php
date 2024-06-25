<?php

namespace App\Http\Controllers;

use App\Apartar;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Cliente;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ClienteFormRequest;
use App\Reserva;
use App\TipoDocumento;
use App\Venta;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $Cliente = DB::table('cliente as a')
                ->select(
                    'a.IdCliente',
                    'a.Nombre',
                    'a.Apellido',
                    'a.Celular',
                    'a.Correo',
                    'a.TipDocumento',
                    'a.NumDocumento',
                    'a.Direccion',
                    'nroMatricula'
                )
                ->where('a.Nombre', 'LIKE', '%' . $query . '%')
                ->orwhere('a.NumDocumento', 'LIKE', '%' . $query . '%')
                ->orderBy('Nombre')
                ->paginate(15);

            return view('reserva.clientes.index', ["Cliente" => $Cliente, "searchText" => $query]);
        }
    }
    public function create()
    {
        $tipo_documento = TipoDocumento::all();
        return view("reserva.clientes.create", ["tipo_documento" => $tipo_documento]);
    }
    public function store(ClienteFormRequest $request)
    {
        try {
            $cliente = new Cliente;
            $cliente->Nombre = $request->get('Nombre');
            $cliente->Apellido = $request->get('Apellido');
            $cliente->Celular = $request->get('Celular');
            $cliente->Correo = $request->get('Correo');
            $tipo_documento = explode('_', $request->get('TipDocumento'));
            $cliente->TipDocumento = $tipo_documento[0];
            $cliente->NumDocumento = $request->get('NumDocumento');
            $cliente->Direccion = $request->get('Direccion');
            $cliente->nroMatricula = $request->get('nroMatricula');

            // $img = $request -> get ('fotocamara');
            // $img = str_replace('data:image/png;base64,', '', $img);
            // $img = str_replace(' ', '+', $img);
            // $image = base64_decode($img);
            // $extension="png";
            // $filename=$request -> get ('NumDocumento').date('h-i-s'). date('m-d') . '.'.$extension;
            // $cliente -> captura = $filename;
            // Image::make($image)->save(public_path("Imagenes/cliente"."/".$filename));

            $cliente->save();
            return Redirect::to('reserva/clientes')->with("success", "¡Satisfactorio!, " . $cliente->Nombre . ' agregado.');
        } catch (\Exception $e) {
            return redirect()->back()->with("error", '¡Error!, ' . $e->getMessage());
        }
    }



    public function obtenerClientes(Request $request){
        $idCliente = $request->get('IdCliente');
        $clientes = Cliente::orderBy('Nombre')->get();
        
        $select = '<select class="form-control form-control-sm selectpicker" data-live-search="true" id="IdCliente" name="IdCliente" required>';
        $select .= '<option value="" selected hidden>Seleccionar </option>';
        
        foreach ($clientes as $c) {
            $select .= '<option value="' . $c->IdCliente . '"' . ($c->IdCliente == $idCliente ? 'selected' : '')  .  '>' . $c->NumDocumento . ' | ' . $c->Nombre . '</option>';
        }
        $select .= '</select>';

        $select2 = '<select class="form-control form-control-sm selectpicker" data-live-search="true" id="IdCliente_e" name="IdCliente" required>';
        $select2 .= '<option value="" selected hidden>Seleccionar </option>';
        
        foreach ($clientes as $c) {
            $select2 .= '<option value="' . $c->IdCliente . '"' . ($c->IdCliente == $idCliente ? 'selected' : '')  .  '>' . $c->NumDocumento . ' | ' . $c->Nombre . '</option>';
        }
        
        $select2 .= '</select>';

        $select3 = '<select class="form-control form-control-sm selectpicker" data-live-search="true" id="idHuespedAdicional" name="idHuespedAdicional">';
        $select3 .= '<option value="" selected hidden>Seleccionar </option>';
        
        foreach ($clientes as $c) {
            $select3 .= '<option value="' . $c->IdCliente . '_' . $c->Nombre . '_' . $c->NumDocumento . '"'  .  '>' . $c->NumDocumento . ' | ' . $c->Nombre . '</option>';
        }
        
        $select3 .= '</select>';
        
         return response()->json(['success' => true, 'select' => $select, 'select2' => $select2, 'select3' => $select3]);
    }

    public function guardarCliente(Request $request){
        try {
            $tipoDocumento = TipoDocumento::where('idTipDoc', $request->get('idTipDoc'))->first();
            $validator = Validator::make($request->all(), [
                'idTipDoc' => 'required',
                'NumDocumento'=>'required|size:' . $tipoDocumento->longitud . '|unique:cliente,NumDocumento,'. null .',IdCliente',
                'Nombre' => 'required|string|min:4|max:255|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
                'Celular' => 'max:15',
                'Correo' => 'max:40',
                'Direccion' => 'max:40',
                'nroMatricula' => 'max:50',
            ], [
                'Nombre.regex' => 'El campo nombre solo debe contener letras y espacios.',
                'NumDocumento.size' => 'El campo debe contener :size caracteres.',
            ]);

            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->messages() as $field => $messages) {
                    foreach ($messages as $message) {
                        $errors[] = ['field' => $field, 'message' => $message];
                    }
                }
                return new JsonResponse(['success' => false, 'errors' => $errors], 422);
            }
            $cliente = new Cliente;
            $cliente->Nombre = $request->get('Nombre');
            $cliente->Celular = $request->get('Celular');
            $cliente->Correo = $request->get('Correo');
            $cliente->TipDocumento = $tipoDocumento->nomTipDoc;
            $cliente->NumDocumento = $request->get('NumDocumento');
            $cliente->Direccion = $request->get('Direccion');
            $cliente->nroMatricula = $request->get('nroMatricula');
            $cliente->save();

            return response()->json(['success' => true, 'idCliente' => $cliente->IdCliente]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        $registro = DB::table('pago as p')->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->where('IdCliente', $id)
            ->orderByDesc('IdPago')
            ->get();
        return  view('reserva.clientes.show', compact("registro", "cliente"));

    }
    public function edit($id)
    {
        $Cliente = Cliente::findOrFail($id);
        $tipo_documento = TipoDocumento::all();
        return view("reserva.clientes.edit", ["Cliente" => $Cliente, "tipo_documento" => $tipo_documento]);
    }
    public function update(ClienteFormRequest $request, $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->Nombre = $request->get('Nombre');
            $cliente->Apellido = $request->get('Apellido');
            $cliente->Celular = $request->get('Celular');
            $cliente->Correo = $request->get('Correo');
            $cliente->TipDocumento = $request->get('TipDocumento');
            $cliente->NumDocumento = $request->get('NumDocumento');
            $cliente->Direccion = $request->get('Direccion');
            $cliente->nroMatricula = $request->get('nroMatricula');
            $cliente->update();
            return Redirect::to('reserva/clientes')->with("success", "¡Satisfactorio!, " . $cliente->Nombre . ' modificado.');
        } catch (\Exception $e) {
            return redirect()->back()->with("error", '¡Error!, ' . $e->getMessage());
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu   = Cliente::findOrFail($id);

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

    public static function validate_destroy ($id){
        $apartar = Apartar::where('IdCliente', $id)->count();
        $reserva = Reserva::where('IdCliente', $id)->count();
        $venta = Venta::where('IdCliente', $id)->count();

        return $apartar == 0 && $reserva == 0 && $venta == 0 ? true : false;
    }
}
