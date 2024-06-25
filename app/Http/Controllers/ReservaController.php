<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Lima');

use App\Apartar;
use App\Cliente;
use App\Datos;
use App\DetalleServicio;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Habitacion;
use App\Reserva;
use App\Pago;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ReservaFormRequest;
use App\Nivel;
use App\Personal;
use App\Servicio;
use App\TipoDocumento;
use App\TipoLimpieza;
use  Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\ApartarController as AC;
use App\HuespedAdicional;
use App\Pago2;
use App\Renovacion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {

            $query = trim($request->get('searchText'));
            // $reserva = DB::table('reserva as r')
            //     ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')
            //     ->join('cliente as c', 'r.IdCliente', '=', 'c.IdCliente')
            //     ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            //     ->select(
            //         'IdReserva',
            //         'r.IdCliente',
            //         'FechEntrada',
            //         'FechSalida',
            //         'horaSalida',
            //         'CostoAlojamiento',
            //         'Observacion',
            //         'r.Estado as EsReser',
            //         'servicio',
            //         'r.Num_Hab',
            //         'u.NumDocumento',
            //         'u.Nombre',
            //         'c.Nombre as nomcli',
            //         'c.Apellido as apecli'
            //     )->get();
            $reserva = DB::table('pago as p')
                ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
                ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')
                ->join('tipohabitacion as t', 'h.IdTipoHabitacion', '=', 't.IdTipoHabitacion')
                ->join('nivel as n', 'h.IdNivel', '=', 'n.IdNivel')
                ->join('cliente as c', 'r.IdCliente', '=', 'c.IdCliente')
                ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
                ->select(
                    'r.IdReserva',
                    'r.IdCliente',
                    'FechEntrada',
                    'HoraEntrada',
                    'FechSalida',
                    'horaSalida',
                    'CostoAlojamiento',
                    'Observacion',
                    'r.Estado as EsReser',
                    'h.Estado as EsHab',
                    'servicio',
                    'r.Num_Hab',
                    'u.NumDocumento',
                    'u.Nombre',
                    'c.Nombre as nomcli',
                    'c.Apellido as apecli',
                    't.Denominacion as tipoden',
                    't.Descripcion as tipoDes',
                    'n.Denominacion as nivDen',
                    't.precioHora',
                    't.precioHora6',
                    't.precioHora8',
                    't.precioNoche',
                    't.precioMes',
                    'r.descuento',
                    'r.metodoPago',
                    'departure_date'
                )->get();

            $nivel = Nivel::all();

            $habitacion = DB::table('habitacion as h')
                ->join('nivel as n', 'h.IdNivel', '=', 'n.IdNivel')
                ->join('tipohabitacion as t', 'h.IdTipoHabitacion', '=', 't.IdTipoHabitacion')
                ->select(
                    'Num_Hab',
                    'h.Descripcion',
                    'Estado',
                    'Precio',
                    'idDetLim',
                    'n.Denominacion as nivelden',
                    't.Denominacion as tipoden'
                )
                ->where('h.IdNivel',  empty($query) ? '!=' : '=', $query)
                ->orderBy('Num_Hab')
                ->paginate(20);
            // Para modal
            $personal = Personal::all();
            $tipo_limpieza = TipoLimpieza::all();
            return view('reserva.registro.index', [
                "reserva" => $reserva, "habitacion" => $habitacion, "nivel" => $nivel,
                "personal" => $personal, "tipo_limpieza" => $tipo_limpieza, "searchText" => $query
            ]);
        }
    }

    public function CrearReserva($id)
    {
        // $Habitacion = Habitacion::findOrFail($id);
        $Habitacion = DB::table('habitacion as h')
            ->join('nivel as n', 'h.IdNivel', '=', 'n.IdNivel')
            ->join('tipohabitacion as t', 'h.IdTipoHabitacion', '=', 't.IdTipoHabitacion')
            ->select(
                'Num_Hab',
                'h.Descripcion as deshab',
                'Estado',
                'Precio',
                'precioHora',
                'precioHora6',
                'precioHora8',
                'precioNoche',
                'precioMes',
                'n.Denominacion as nivelden',
                't.Denominacion as tipoden'
            )
            ->where('Num_Hab', '=', $id)
            ->first();
        // $Habitacion=DB::table('Habitacion')
        // ->get();
        // Generamos la reserva para el autoincrement
        $Reserva = DB::table('reserva')
            ->orderBy('IdReserva', 'desc')
            ->limit(1);
        $Reserva = $Reserva->first();

        $Cliente = DB::table('cliente')
            ->orderBy('IdCliente', 'desc')
            ->get();

        $Usuario = DB::table('usuario')->where('IdUsuario', '=', '1')->get();

        $servicio = DB::table('servicio')->get();

        $metPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'];
        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
        // foreach ($servicio as $s) {
        //     echo $s->idServicio . '<br>';
        // }
        $tipo_documento = TipoDocumento::all();
        $datos_empresa = Datos::first();
        return view("reserva.registro.create", [
            "Habitacion" => $Habitacion, "Reserva" => $Reserva, "metPago" => $metPago,
            "Cliente" => $Cliente, "Usuario" => $Usuario, "servicioExtra" => $servicio, "caja" => $caja,
            "tipo_documento" => $tipo_documento, "datos_empresa" => $datos_empresa
        ]);
    }
    public function alquiler_reserva_create($id)
    {
        // $Habitacion = Habitacion::findOrFail($id);
        $apartar = Apartar::findOrFail($id);

        $Habitacion = DB::table('habitacion as h')
            ->join('nivel as n', 'h.IdNivel', '=', 'n.IdNivel')
            ->join('tipohabitacion as t', 'h.IdTipoHabitacion', '=', 't.IdTipoHabitacion')
            ->select(
                'Num_Hab',
                'h.Descripcion as deshab',
                'Estado',
                'Precio',
                'precioHora',
                'precioHora6',
                'precioHora8',
                'precioNoche',
                'precioMes',
                'n.Denominacion as nivelden',
                't.Denominacion as tipoden'
            )
            ->where('Num_Hab', $apartar->Num_Hab)
            ->first();

        $Cliente = Cliente::orderByDesc('IdCliente')->get();
        $Usuario = DB::table('usuario')->where('IdUsuario', '=', '1')->get();

        $metPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'];
        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
        // foreach ($servicio as $s) {
        //     echo $s->idServicio . '<br>';
        // }
        $tipo_documento = TipoDocumento::all();
        $datos_hotel = Datos::first();
        return view("reserva.listar-registro.create", [
            "Habitacion" => $Habitacion, "metPago" => $metPago, "Cliente" => $Cliente, "Usuario" => $Usuario, "caja" => $caja,
            "tipo_documento" => $tipo_documento, "apartar" => $apartar, "datos_hotel" => $datos_hotel
        ]);
    }


    public function store(Request $request)
    {

        if ($this->duplicidad_alquiler($request->get('Num_Hab'))) {
            return response()->json(['success' => false, 'message' => "¡Advertencia!, Se encontró que la habitación " . $request->get('Num_Hab') . " ya está ocupada."]);
        }
        $caja = DB::table('caja')->where('montoCierre', null)->first();
        $mytime = Carbon::now('America/Lima');

        // Validamos fecha
        $validarFecha = AC::validarFecha(
            -1,
            $request->get('Num_Hab'),
            $request->get('FechReserva'),
            $mytime->toTimeString(),
            $request->get('FechSalida'),
            $request->get('horaSalida'),
            'r'
        );

        if ($validarFecha) {
            return response()->json(['success' => false, 'message' => "¡Error!, Existe interferencia en el intervalo de fecha."]);
        }

        $persona = $request->get('persona') != null ? $request->get('persona') : [];
        // Validación de Huéspedes
        if (in_array($request->get('IdCliente'), $persona)) {
            return response()->json(['success' => false, 'message' => "¡Error! El huésped principal no puede ser considerado como huésped adicional. Por favor, seleccione a una persona diferente como huésped adicional."]);
        }


        $validator = Validator::make($request->all(), [
            'FechSalida' => 'after_or_equal:FechReserva',
            'CostoAlojamiento' => 'numeric',
            'Observacion' => 'max:200',
            'Estado' => 'required',
            'IdCliente' => 'required',
            'Num_Hab' => 'required',
            'Adelanto'=> 'numeric|min:0',
            'Descuento' => !empty($request->get('Descuento')) ? 'numeric|max:'. $request->get('CostoAlojamiento') . '|min:0' : '',
        ], [
            'Num_Hab.required' => 'Debe seleccionar una Habitación.',
            'Adelanto.max' => 'El Adelanto no debe ser mayor a ' . $request->get('pagar') . '.',
            'Descuento.max' => 'El Descuento no debe ser mayor a ' . $request->get('CostoAlojamiento') . '.',
            'Adelanto.min' => 'El Adelanto no debe ser un valor negativo.',
            'Descuento.min' => 'El Descuento no debe ser un valor negativo.',
            'FechSalida.after_or_equal' => 'La Fecha de salida debe ser una fecha posterior o igual a la fecha de entrada.'
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



        DB::beginTransaction();
        try {

            $Reserva = new Reserva;
            $Reserva->FechEntrada = $request->get('FechReserva');
            $Reserva->FechReserva = $mytime->toDateString();
            $Reserva->HoraEntrada = $mytime->toTimeString();
            // $Reserva -> FechReserva = "";
            $ES  = "OCUPADO";

            // ----------------------------------------
            $Reserva->entry_date = $mytime->toDateTimeString();

            $Reserva->FechSalida = $request->get('FechSalida');
            $Reserva->descuento = $request->get('Descuento');
            $Reserva->CostoAlojamiento = $request->get('CostoAlojamiento');
            $Reserva->Observacion = $request->get('Observacion');
            $Reserva->Estado = $request->get('Estado');
            $Reserva->horaSalida = $request->get('horaSalida');
            $Reserva->toalla = $request->get('toalla');
            $Reserva->servicio = $request->get('servicio');
            $Reserva->IdCliente = $request->get('IdCliente');
            $Reserva->Num_Hab = $request->get('Num_Hab');
            $Reserva->cantMes = $request->get('cantida_m');
            $Reserva->metodoPago = $request->get('metodoPago');
            $Reserva->IdUsuario = auth()->user()->IdUsuario;
            $Reserva->regPago = true;
            $Reserva->save();


            $Pago = new Pago;
            $mytime = Carbon::now('America/Lima');
            $Pago->FechaPago = $mytime->toDateTimeString();
            // ---------------------------------------------------
            $Pago->departure_date = $request->get('FechSalida') . ' ' . $request->get('horaSalida');

            // Validamos si se le entregó mas del mosto establecido
            if ($request->get('text_f_value') == 'CAMBIO') {
                $Pago->TotalPago = $request->get('Adelanto') - $request->get('pagar');
            } else {
                $Pago->TotalPago = $request->get('Adelanto');
            }
            // ------------------------------------------------

            if ($request->get('CostoAlojamiento') == $request->get('Adelanto')) {
                $Pago->Estado = "PAGADO";
            } else {
                $Pago->Estado = "FALTA PAGAR";
            }
            $Pago->IdReserva = $Reserva->IdReserva;
            $Pago->codCaja =  $caja->codCaja;
            $Pago->save();

            // Detalle Servicios ------------------------------------------------------------------
            // if ($request->get('codProducto') != null) {
            //     $IdProducto = $request->get('codProducto');
            //     $precioVenta = $request->get('precioVenta');
            //     $cantidad = $request->get('cantidad');
            //     $cont = 0;
            //     while ($cont < count($IdProducto)) {
            //         $detalle = new DetalleServicio();
            //         $detalle->IdReserva = $Reserva->IdReserva;
            //         $detalle->idServicio = $IdProducto[$cont];
            //         $detalle->precioDS = $precioVenta[$cont];
            //         $detalle->cantidadDS = $cantidad[$cont];
            //         $detalle->save();
            //         $cont = $cont + 1;
            //     }
            // }

            // Registrar Huespedes Adicionales
            for ($i = 0; $i < count($persona); $i++) {
                $acompaniante = new HuespedAdicional();
                $acompaniante->IdReserva = $Reserva->IdReserva;
                $acompaniante->IdCliente = $persona[$i];
                $acompaniante->save();
            }

            $Habitacion = Habitacion::findOrFail($request->get('Num_Hab'));
            $Habitacion->Estado = $ES;
            $Habitacion->update();
            DB::commit();
            return response()->json(['success' => true, 'message' => "¡Satisfactorio!, Alquiler Registrado en la Hab. " . $Habitacion->Num_Hab, 
                'redireccionar' => route('registro.index')]);
          
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        $Habitacion = DB::table('habitacion as h')
            ->join('nivel as n', 'h.IdNivel', '=', 'n.IdNivel')
            ->join('tipohabitacion as t', 'h.IdTipoHabitacion', '=', 't.IdTipoHabitacion')
            ->select(
                'Num_Hab',
                'h.Descripcion as deshab',
                'Estado',
                'Precio',
                'n.Denominacion as nivelden',
                't.Denominacion as tipoden'
            )
            ->where('Num_Hab', '=', $id)
            ->first();

        $Cliente = DB::table('Cliente')
            ->get();
        $reserva = DB::table('Reserva')
            ->where('Num_Hab', '=', $id)
            ->where('Estado', '!=', 'H. CULMINADO')
            ->orderBy('Estado', 'asc')
            ->orderBy('IdReserva', 'asc')
            ->first();

        $pago = DB::table('Pago as p')
            ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')
            ->where('r.Num_Hab', '=', $id)
            ->first();

        return view("reserva.registro.edit", [
            "Habitacion" => $Habitacion, "reserva" => $reserva,
            "Cliente" => $Cliente, "pago" => $pago
        ]);
    }

    public function update(ReservaFormRequest $request, $id)
    {
        $Reserva = Reserva::findOrFail($id);
        $indicador = $request->get('Estado');
        if ($indicador == "RESERVAR") {
            $Reserva->FechReserva = $request->get('FechReserva');
            $ES  = "RESERVADO";
        } else if ($indicador == "HOSPEDAR") {
            $Reserva->FechReserva = $request->get('FechReserva');
            $Reserva->FechEntrada = $request->get('FechReserva');
            $ES  = "OCUPADO";
        }
        $Reserva->FechSalida = $request->get('FechSalida');
        $Reserva->descuento = $request->get('Descuento');
        $Reserva->CostoAlojamiento = $request->get('CostoAlojamiento');
        $Reserva->Observacion = $request->get('Observacion');
        $Reserva->horaSalida = $request->get('horaSalida');
        $Reserva->Estado = $request->get('Estado');
        $Reserva->toalla = $request->get('toalla');
        $Reserva->servicio = $request->get('servicio');
        $Reserva->IdCliente = $request->get('IdCliente');
        $Reserva->Num_Hab = $request->get('Num_Hab');
        $Reserva->IdUsuario = "1";
        $Reserva->update();

        $Pago = Pago::findOrFail($request->get('IdPago'));
        $mytime = Carbon::now('America/Lima');
        $Pago->FechaPago = $mytime->toDateTimeString();
        $Pago->TotalPago = $request->get('Adelanto');
        if ($request->get('CostoAlojamiento') == $request->get('Adelanto')) {
            $Pago->Estado = "PAGADO";
        } else {
            $Pago->Estado = "FALTA PAGAR";
        }
        $Pago->update();

        $Habitacion = Habitacion::findOrFail($request->get('Num_Hab'));
        $Habitacion->Estado = $ES;
        $Habitacion->update();

        return Redirect::to('reserva/registro');
    }

    public function show($id)
    {
        $n_id = substr($id, 1);
        $Habitacion = Habitacion::findOrFail($n_id);

        //Verificamos la existencia de alguna reserva de la habitación
        $reserva = DB::table('reserva as r')
            ->where('r.Num_Hab', '=', $n_id)->where('r.FechReserva', ">=", date('Y-m-d'))->where('r.Estado', '=', 'RESERVAR')
            ->first();
        if (!isset($reserva->IdReserva)) {
            $Habitacion->Estado = "DISPONIBLE";
        } else {
            $Habitacion->Estado = "RESERVADO";
        }

        Session::flash('message', $n_id);
        $Habitacion->update();
        return Redirect::to('reserva/registro');
    }

    public function exportPdf($id)
    {
        $reserva = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')
            ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')
            ->join('cliente as c', 'r.IdCliente', '=', 'c.IdCliente')
            ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            ->join('tipohabitacion as th', 'h.IdTipoHabitacion', '=', 'th.IdTipoHabitacion')
            ->select(
                'r.IdReserva',
                'r.IdCliente',
                'FechEntrada',
                'FechSalida',
                'c.NumDocumento as Ndcliente',
                'CostoAlojamiento',
                'Observacion',
                'r.Estado as EsReser',
                'c.Celular',
                'c.Direccion',
                'r.Num_Hab',
                'u.NumDocumento',
                'u.Nombre',
                'r.Descuento',
                'r.HoraEntrada',
                'horaSalida',
                'h.Precio as prehab',
                'th.Denominacion',
                'p.IdPago',
                'p.TotalPago',
                'p.Penalidad',
                'metodoPago',
                'c.Nombre as nomcli',
                'c.Apellido as apecli'
            )
            ->where('r.IdReserva', '=', $id)
            ->first();

        $consumo = DB::table('consumo as c')
            ->join('producto as p', 'c.IdProducto', '=', 'p.IdProducto')
            ->where('IdReserva', '=', $id)
            ->get();

        $servicio = DetalleServicio::where('IdReserva', $id)->select(DB::raw('SUM(precioDS * cantidadDS) as precioDS'))->first();

        $datos_empresa = DB::table('datos_hotel')->first();
        $fecha_actual = fechaCastellano(date('d-m-Y H:i:s'));
        $pdf = \PDF::loadView('reserva/listar-registro/comprobante', [
            "reserva" => $reserva, "datos_empresa" => $datos_empresa,
            "consumo" => $consumo, "servicio" => $servicio, "fecha_actual" => $fecha_actual
        ])
            ->setPaper(array(0, 0, 204, 650));
        return $pdf->stream();
    }
    public static function duplicidad_alquiler($num_hab)
    {
        $registro = Reserva::where('Num_Hab', $num_hab)->where('Estado', 'HOSPEDAR')->first();
        return $registro ? true : false;
    }


    public function renovarAlquiler($id)
    {
        $reserva = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')
            ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')
            ->join('cliente as c', 'r.IdCliente', '=', 'c.IdCliente')
            // ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            ->join('tipohabitacion as th', 'h.IdTipoHabitacion', '=', 'th.IdTipoHabitacion')
            ->where('r.IdReserva', $id)
            ->first();

        $habitacion = DB::table('habitacion as h')
            ->join('nivel as n', 'h.IdNivel', '=', 'n.IdNivel')
            ->join('tipohabitacion as t', 'h.IdTipoHabitacion', '=', 't.IdTipoHabitacion')
            ->select(
                'Num_Hab',
                'h.Descripcion as deshab',
                'Estado',
                'Precio',
                'precioHora',
                'precioHora6',
                'precioHora8',
                'precioNoche',
                'precioMes',
                'n.Denominacion as nivelden',
                't.Denominacion as tipoden'
            )
            ->where('Num_Hab', $reserva->Num_Hab)
            ->first();

        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();

        return view('reserva.registro.renovar', compact("reserva", "habitacion", "caja"));
    }

    public function renovar_post(Request $request)
    {
        DB::beginTransaction();
        try {
            $caja = DB::table('caja')->where('montoCierre', null)->first();
            // --------------------
            $mytime = Carbon::now('America/Lima');
            $fecha_hora = $mytime->toDateTimeString();
            $renovacion = new Renovacion();
            $renovacion->fRenovacion = $fecha_hora;
            $renovacion->fIniRen = $request->get('fIniRen');
            $renovacion->fFinRen = $request->get('FechSalida') . ' ' . $request->get('horaSalida');
            $renovacion->tarRen = $request->get('servicio');
            $renovacion->canRen = $request->get('cantida_m');
            $renovacion->metPagRen = $request->get('metodoPago');
            $renovacion->descuentoRen = empty($request->get('descuento')) ? 0 : $request->get('descuento');
            $renovacion->cosRen = $request->get('CostoAlojamiento');
            $renovacion->codCaja = $caja->codCaja;
            $renovacion->IdReserva = $request->get('IdReserva');
            $renovacion->save();
            // ------------------------ Obtenemos N° Hab para el mensaje
            $reserva = Reserva::findOrFail($request->get('IdReserva'));
            // ---------------------------- Modificamos la fecha final del alquiler
            $pago = Pago::where('IdReserva', $request->get('IdReserva'))->first();
            $pago->departure_date = $request->get('FechSalida') . ' ' . $request->get('horaSalida');
            $pago->update();
            // ----------------------------- Si pago recibido mayor a 0, realizamos un pago
            if (floatval($request->get('montoRecibidoRen')) > 0) {
                # code...
                $myTime = Carbon::now('America/Lima');
                $registro = new Pago2();
                $registro->fecPag = $myTime->toDateTimeString();
                $registro->motPag = "";
                $registro->metPag = $request->get('metodoPago');
                $registro->desPag = 0;
                $registro->monPag = $request->get('montoRecibidoRen');
                $registro->IdReserva = $request->get('IdReserva');
                $registro->codCaja = $caja->codCaja;
                $registro->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with("error", $e->getMessage());
        }
        return Redirect::to('reserva/registro')->with('success', '¡Satisfactorio!,  Se renovó el alquiler de la Hab. ' . $reserva->Num_Hab);
    }

    public function add_service($id)
    {
        $reserva = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')
            ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')
            ->join('cliente as c', 'r.IdCliente', '=', 'c.IdCliente')
            ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            ->join('tipohabitacion as th', 'h.IdTipoHabitacion', '=', 'th.IdTipoHabitacion')
            ->where('r.IdReserva', $id)
            ->first();

        $habitacion = DB::table('habitacion as h')
            ->join('nivel as n', 'h.IdNivel', '=', 'n.IdNivel')
            ->join('tipohabitacion as t', 'h.IdTipoHabitacion', '=', 't.IdTipoHabitacion')
            ->select(
                'Num_Hab',
                'h.Descripcion as deshab',
                'Estado',
                'Precio',
                'precioHora',
                'precioHora6',
                'precioHora8',
                'precioNoche',
                'precioMes',
                'n.Denominacion as nivelden',
                't.Denominacion as tipoden'
            )
            ->where('Num_Hab', $reserva->Num_Hab)
            ->first();
        $servicioExtra = DB::table('servicio')->get();
        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();

        return view('reserva.registro.servicio', compact("reserva", "habitacion", "servicioExtra", "caja"));
    }

    public function add_service_post(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        try {
            $caja = DB::table('caja')->where('montoCierre', null)->first();
            $reserva = Reserva::findOrFail($request->get('IdReserva'));
            if ($request->get('codProducto') != null) {
                $IdProducto = $request->get('codProducto');
                $precioVenta = $request->get('precioVenta');
                $cantidad = $request->get('cantidad');
                $cont = 0;
                while ($cont < count($IdProducto)) {
                    $detalle = new DetalleServicio();
                    $detalle->IdReserva = $reserva->IdReserva;
                    $detalle->idServicio = $IdProducto[$cont];
                    $detalle->precioDS = $precioVenta[$cont];
                    $detalle->cantidadDS = $cantidad[$cont];
                    $detalle->metPagDse = $request->get('metodoPago');
                    $detalle->estServicio = $request->get('estServicio');
                    $detalle->fdServicio = $fecha;

                    $detalle->codCaja = $caja->codCaja;
                    $detalle->save();
                    $cont = $cont + 1;
                }
            }
            return Redirect::to('reserva/registro')->with('success', '¡Satisfactorio!,  Se agregó el/los servicio(s) a la Hab. ' . $reserva->Num_Hab);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}


function fechaCastellano($fecha)
{
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $nombredia . " " . $numeroDia . " de " . $nombreMes . " de " . $anio;
}
