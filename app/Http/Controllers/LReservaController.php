<?php

namespace App\Http\Controllers;

use App\Apartar;
use App\Consumo;
use App\DetalleServicio;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Reserva;
use App\Pago;
use App\Pago_Alter;
use App\Habitacion;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ReservaFormRequest;
use App\RespAlquiler;
use App\TipoDocumento;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReservaController as RC;
use App\Http\Controllers\ApartarController as AC;
use App\HuespedAdicional;
use App\IngresoCaja;
use App\Renovacion;
use Carbon\Carbon;
use  Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class LreservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        date_default_timezone_set('America/Lima');
        $mytime = Carbon::now('America/Lima');
        $start = Carbon::now()->startOfYear()->toDateString();
        $fecha = date('Y-m-t', strtotime($mytime->toDateString()));

        if ($request) {
            $query = trim($request->get('searchText'));
            $query2 = trim($request->get('searchText2'));
            $query3 = trim($request->get('searchText3'));
            $query4 = trim($request->get('searchText4'));

            $query3 = empty($query3) ? $start : $query3;
            $query4 = empty($query4) ? $fecha : $query4;

            if ($query == "") {
                $reserva = DB::table('pago as p')
                    ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
                    ->join('habitacion as h', 'r.Num_Hab', 'h.Num_Hab')->join('cliente as c', 'r.IdCliente', 'c.IdCliente')->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
                    ->select(
                        'r.IdReserva',
                        'r.IdCliente',
                        'FechEntrada',
                        'FechSalida',
                        'CostoAlojamiento',
                        'Observacion',
                        'FechReserva',
                        'r.Estado as EsReser',
                        'r.Num_Hab',
                        'u.NumDocumento',
                        'u.Nombre',
                        'c.Nombre as nomcli',
                        'c.Apellido as apecli',
                        'c.NumDocumento as docli',
                        'c.Celular',
                        'r.Num_Hab',
                        'Observacion',
                        'p.FechaEmision',
                        'r.horaSalida',
                        'regPago',
                        'r.HoraEntrada',
                        'r.toalla',
                        'r.servicio',
                        'horaSalida_o',
                        'codCaja'
                    )
                    ->where('r.Num_Hab', 'LIKE', '%' . $query . '%')
                    ->where('r.Estado', 'LIKE', '%' . $query2 . '%')
                    // ->where('FechReserva', 'LIKE', '%' . $query3 . '%')
                    ->whereBetween('FechReserva', [$query3, $query4])
                    // ->where('FechSalida', 'LIKE', '%' . $query4 . '%')
                    ->orderBy('r.Estado', 'desc')
                    ->orderBy('r.FechReserva', 'desc')
                    ->paginate(10);
            } else {
                $reserva = DB::table('pago as p')
                    ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')
                    ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')->join('cliente as c', 'r.IdCliente', '=', 'c.IdCliente')->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
                    ->select(
                        'r.IdReserva',
                        'r.IdCliente',
                        'FechEntrada',
                        'FechSalida',
                        'CostoAlojamiento',
                        'Observacion',
                        'FechReserva',
                        'r.Estado as EsReser',
                        'r.Num_Hab',
                        'u.NumDocumento',
                        'u.Nombre',
                        'c.Nombre as nomcli',
                        'c.Apellido as apecli',
                        'c.NumDocumento as docli',
                        'c.Celular',
                        'r.Num_Hab',
                        'Observacion',
                        'p.FechaEmision',
                        'r.horaSalida',
                        'regPago',
                        'r.HoraEntrada',
                        'r.toalla',
                        'r.servicio',
                        'horaSalida_o',
                        'codCaja'
                    )
                    ->where('r.Num_Hab', '=', $query)
                    ->where('r.Estado', 'LIKE', '%' . $query2 . '%')
                    // ->where('FechReserva', 'LIKE', '%' . $query3 . '%')
                    ->whereBetween('FechReserva', [$query3, $query4])
                    // ->where('FechSalida', 'LIKE', '%' . $query4 . '%')
                    ->orderBy('r.Estado', 'desc')
                    ->orderBy('r.FechReserva', 'desc')
                    ->paginate(10);
            }

            $habitacion = DB::table('habitacion as h')->get();

            $caja = DB::table('caja')->where('montoCierre', null)->first();

            return view('reserva.listar-registro.index', [
                "reserva" => $reserva, "habitacion" => $habitacion,
                "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3, "searchText4" => $query4, "caja" => $caja
            ]);
        }
    }

    public function create(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $Habitacion = DB::table('habitacion as h')
                ->join('nivel as n', 'h.IdNivel', '=', 'n.IdNivel')
                ->join('tipohabitacion as t', 'h.IdTipoHabitacion', '=', 't.IdTipoHabitacion')
                ->select(
                    'Num_Hab',
                    'h.Descripcion as deshab',
                    'Estado',
                    'Precio',
                    'precioHora',
                    'precioNoche',
                    'precioMes',
                    'n.Denominacion as nivelden',
                    't.Denominacion as tipoden'
                )->get();

            $Cliente = DB::table('cliente')->orderBy('Nombre')->get();


            $new_query = explode("_", $query);

            $reserva = DB::table('reserva')
                ->where('Num_Hab', '=', $new_query[0])
                ->where('Estado', '!=', 'H. CULMINADO')
                ->orderBy('FechReserva')
                ->get();

            // Generamos la reserva para el autoincrement
            $Reserva2 = DB::table('reserva')
                ->orderBy('IdReserva', 'desc')
                ->limit(1);
            $Reserva2 = $Reserva2->first();

            return view("reserva.listar-registro.create", [
                "Habitacion" => $Habitacion, "Cliente" => $Cliente, "reserva" => $reserva, "Reserva2" => $Reserva2,
                "searchText" => $new_query[0]
            ]);
        }
    }

    public function store(Request $request)
    {

        if ($this->duplicidad_alquiler($request->get('Num_Hab'))) {
            return response()->json(['success' => false, 'message' => "¡Advertencia!, Se encontró que la habitación " . $request->get('Num_Hab') . " ya está ocupada."]);
        }

        $caja = DB::table('caja')->where('montoCierre', null)->first();
        $mytime = Carbon::now('America/Lima');

        $validarFecha = AC::validarFecha(
            $request->get('idApartar'),
            $request->get('Num_Hab'),
            $request->get('FechReserva'),
            $mytime->toTimeString(),
            $request->get('FechSalida'),
            $request->get('horaSalida'),
            'a'
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
            // Validamos fecha


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
            // Eliminamos el apartar
            $apartar = Apartar::findOrfail($request->get('idApartar'));
            $apartar->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => "¡Satisfactorio!, Alquiler Registrado en la Hab. " . $Habitacion->Num_Hab, 
                'redireccionar' => route('registro.index')]);


        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }



    public function edit($id, Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

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
                )->get();

            $Cliente = DB::table('cliente')->orderByDesc('IdCliente')->get();

            //Propio del ID
            $Reserva3 = Reserva::findOrFail($id);


            $new_query = explode("_", $query);
            if ($query == '') {
                $quer4 = $Reserva3->Num_Hab;
            } else {
                $quer4 = $new_query[0];
            }

            $reserva = DB::table('reserva')
                ->where('Num_Hab', '=', $quer4)
                ->where('Estado', '!=', 'H. CULMINADO')
                ->where('IdReserva', '!=', $id)
                ->orderBy('FechReserva')
                ->get();
            // Para consultar el Adelanto(Pago)
            $Pago = DB::table('pago')->where('IdReserva', $id)->first();

            // Generamos la reserva para el autoincrement
            $Reserva2 = DB::table('reserva')
                ->orderBy('IdReserva', 'desc')
                ->limit(1)->first();

            $tipo_documento = TipoDocumento::all();
            $servicio = DB::table('servicio')->get();
            $metPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'];

            return view("reserva.listar-registro.edit", [
                "Habitacion" => $Habitacion, "Pago" => $Pago, "tipo_documento" => $tipo_documento,
                "Cliente" => $Cliente, "reserva" => $reserva, "Reserva2" => $Reserva2, "Reserva3" => $Reserva3, "servicioExtra" => $servicio,
                "metPago" => $metPago, "searchText" => $new_query[0]
            ]);
        }
    }
    public function update(ReservaFormRequest $request, $id)
    {

        // if (RC::duplicidad_alquiler($request->get('Num_Hab'))) {
        //     return Redirect::to('reserva/registro')->with("error", "¡Advertencia!, Se encontró que la habitación " . $request->get('Num_Hab') . " ya está ocupada.");
        // }

        try {
            $mytime = Carbon::now('America/Lima');
            $Reserva = Reserva::findOrFail($id);
            // Validamos fecha
            $validarFecha = AC::validarFecha(
                $Reserva->IdReserva,
                $request->get('Num_Hab'),
                $request->get('FechReserva'),
                $mytime->toTimeString(),
                $request->get('FechSalida'),
                $request->get('horaSalida'),
                'r'
            );

            if (!$validarFecha) {

                $indicador = $request->get('Estado');
                if ($indicador == "RESERVAR") {
                    $Reserva->FechReserva = $request->get('FechReserva');
                    $ES  = "RESERVADO";
                } else if ($indicador == "HOSPEDAR") {
                    $Reserva->FechReserva = $request->get('FechReserva');
                    $Reserva->FechEntrada = $request->get('FechReserva');
                    $ES  = "OCUPADO";
                    $Reserva->HoraEntrada = $mytime->toDateTimeString();
                }
                $Reserva->FechSalida = $request->get('FechSalida');
                // -------------------------------
                $Reserva->entry_date = $mytime->toDateTimeString();

                $Reserva->descuento = $request->get('Descuento');
                $Reserva->CostoAlojamiento = $request->get('CostoAlojamiento');
                $Reserva->Observacion = $request->get('Observacion');
                // $Reserva -> Estado =$request -> get ('Estado');
                $Reserva->horaSalida = $request->get('horaSalida');
                $Reserva->toalla = $request->get('toalla');
                $Reserva->servicio = $request->get('servicio');
                $cliente = explode('_', $request->get('IdCliente'));
                $Reserva->IdCliente = $cliente[0];
                $Reserva->Num_Hab = $request->get('Num_Hab');
                $Reserva->regPago = true;
                $Reserva->IdUsuario = auth()->user()->IdUsuario;
                $Reserva->update();

                $Pago = Pago::findOrFail($request->get('IdPago'));
                $mytime = Carbon::now('America/Lima');
                $Pago->departure_date = $request->get('FechSalida') . ' ' . $request->get('horaSalida');
                $Pago->FechaPago = $mytime->toDateTimeString();
                $Pago->FechaEmision = $request->get('FechSalida');
                $Pago->horaSalida_o = $request->get('horaSalida');
                $Pago->TotalPago = $request->get('Adelanto');
                if ($request->get('CostoAlojamiento') == $request->get('Adelanto')) {
                    $Pago->Estado = "PAGADO";
                } else {
                    $Pago->Estado = "FALTA PAGAR";
                }
                $Pago->update();

                // Detalle Servicios ------------------------------------------------------------------
                if ($request->get('codProducto') != null) {
                    $IdProducto = $request->get('codProducto');
                    $precioVenta = $request->get('precioVenta');
                    $cantidad = $request->get('cantidad');
                    $cont = 0;
                    while ($cont < count($IdProducto)) {
                        $detalle = new DetalleServicio();
                        $detalle->IdReserva = $Reserva->IdReserva;
                        $detalle->idServicio = $IdProducto[$cont];
                        $detalle->precioDS = $precioVenta[$cont];
                        $detalle->cantidadDS = $cantidad[$cont];
                        $detalle->save();
                        $cont = $cont + 1;
                    }
                }
                $Habitacion = Habitacion::findOrFail($request->get('Num_Hab'));
                $Habitacion->Estado = $ES;
                $Habitacion->update();
            } else {
                return redirect()->back()->with("error", "Existe interferencia en el intervalo de fecha/hora con uno o más registros.");
            }

            return Redirect::to('reserva/listar-registro')->with("success", '¡Satisfactorio!, Registro modificado con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with("error", "¡Error!, " . $e->getMessage() . '.');
        }
    }

    public function show($id)
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
                'precioHora',
                'precioNoche',
                'precioMes',
                'h.Precio as prehab',
                'th.Denominacion',
                'p.IdPago',
                'p.TotalPago',
                'p.Penalidad',
                'c.Nombre as nomcli',
                'c.Apellido as apecli'
            )
            ->where('r.IdReserva', '=', $id)
            ->first();

        $consumo = DB::table('consumo as c')
            ->join('producto as p', 'c.IdProducto', '=', 'p.IdProducto')
            ->where('IdReserva', '=', $id)
            ->get();

        return view("reserva.listar-registro.show", ["reserva" => $reserva, "consumo" => $consumo]);
    }

    public function report($id)
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
                'horaSalida',
                'c.NumDocumento as Ndcliente',
                'CostoAlojamiento',
                'Observacion',
                'r.Estado as EsReser',
                'c.Celular',
                'c.Direccion',
                'metodoPago',
                'r.Num_Hab',
                'u.NumDocumento',
                'u.Nombre',
                'r.HoraEntrada',
                'r.Descuento',
                'precioHora',
                'precioNoche',
                'precioMes',
                'h.Precio as prehab',
                'th.Denominacion',
                'p.IdPago',
                'p.TotalPago',
                'p.Penalidad',
                'FechaEmision',
                'horaSalida_o',
                'c.Nombre as nomcli',
                'c.Apellido as apecli'
            )
            ->where('r.IdReserva', '=', $id)
            ->first();

        $consumo = DB::table('consumo as c')
            ->join('producto as p', 'c.IdProducto', '=', 'p.IdProducto')
            ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
            ->where('IdReserva', '=', $id)
            ->get();

        $pagos = DB::table('pagos')
            ->where('IdReserva', $id)
            ->get();

        $datos_empresa = DB::table('datos_hotel')->first();
        $fecha_actual = fechaCastellano(date('d-m-Y H:i:s'));

        $servicio = DetalleServicio::where('IdReserva', $id)->select(DB::raw('SUM(precioDS * cantidadDS) as precioDS'))->first();

        $servicio_l = DB::table('detalle_servicio as ds')->join('servicio as s', 'ds.idServicio', 's.idServicio')
            ->where('IdReserva', $id)->get();

        $renovaciones = Renovacion::where('IdReserva', $id)->get();

        $deuda_alquiler = IngresoCaja::where('IdReserva', $id)->where('motivo', 'ALQUILER')->first();

        $huespedes_adicional = DB::table('huesped_adicional as h')
            ->join('cliente as c', 'h.IdCliente', 'c.IdCliente')
            ->where('IdReserva', $id)
            ->get();

        $pdf = \PDF::loadView('reserva.listar-registro.report', [
            "reserva" => $reserva, "servicio" => $servicio, "deuda_alquiler" => $deuda_alquiler, "pagos" => $pagos,
            "datos_empresa" => $datos_empresa, "fecha_actual" => $fecha_actual, "consumo" => $consumo, "servicio_l" => $servicio_l,
            "renovaciones" => $renovaciones, "huespedes_adicional" => $huespedes_adicional
        ]);
        return $pdf->stream();
    }

    public function listado($query, $query2, $query3, $query4)
    {
        $mytime = Carbon::now('America/Lima');
        $start = Carbon::now()->startOfYear()->toDateString();
        $fecha = date('Y-m-t', strtotime($mytime->toDateString()));

        if ($query == 'TODO') {
            $query = '';
        }

        if ($query2 == 'TODO') {
            $query2 = '';
        }
        // if ($query3 == 'TODO') {
        //     $query3 = '';
        // }
        // if ($query4 == 'TODO') {
        //     $query4 = '';
        // }
        $query3 = empty($query3) ? $start : $query3;
        $query4 = empty($query4) ? $fecha : $query4;

        if ($query == "") {
            $reserva = DB::table('pago as p')
                ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')
                ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')->join('cliente as c', 'r.IdCliente', '=', 'c.IdCliente')->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
                ->select(
                    'r.IdReserva',
                    'r.IdCliente',
                    'FechEntrada',
                    'FechSalida',
                    'CostoAlojamiento',
                    'Observacion',
                    'FechReserva',
                    'r.Estado as EsReser',
                    'r.Num_Hab',
                    'u.NumDocumento',
                    'u.Nombre',
                    'c.Nombre as nomcli',
                    'c.Apellido as apecli',
                    'c.NumDocumento as docli',
                    'c.Celular',
                    'r.Num_Hab',
                    'Observacion',
                    'p.FechaEmision',
                    'r.horaSalida',
                    'horaSalida_o',
                    'r.HoraEntrada',
                    'r.servicio'
                )
                ->where('r.Num_Hab', 'LIKE', '%' . $query . '%')
                ->where('r.Estado', 'LIKE', '%' . $query2 . '%')
                // ->where('FechReserva', 'LIKE', '%' . $query3 . '%')
                ->whereBetween('FechReserva', [$query3, $query4])
                // ->where('FechSalida', 'LIKE', '%' . $query4 . '%')
                ->orderBy('r.Estado', 'desc')
                ->orderBy('r.FechReserva', 'desc')
                ->get();
        } else {
            $reserva = DB::table('pago as p')
                ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')
                ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')->join('cliente as c', 'r.IdCliente', '=', 'c.IdCliente')->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
                ->select(
                    'r.IdReserva',
                    'r.IdCliente',
                    'FechEntrada',
                    'FechSalida',
                    'CostoAlojamiento',
                    'Observacion',
                    'FechReserva',
                    'r.Estado as EsReser',
                    'r.Num_Hab',
                    'u.NumDocumento',
                    'u.Nombre',
                    'c.Nombre as nomcli',
                    'c.Apellido as apecli',
                    'c.NumDocumento as docli',
                    'c.Celular',
                    'r.Num_Hab',
                    'Observacion',
                    'p.FechaEmision',
                    'r.horaSalida',
                    'horaSalida_o',
                    'r.HoraEntrada',
                    'r.servicio'
                )
                ->where('r.Num_Hab', '=', $query)
                ->where('r.Estado', 'LIKE', '%' . $query2 . '%')
                // ->where('FechReserva', 'LIKE', '%' . $query3 . '%')
                ->whereBetween('FechReserva', [$query3, $query4])
                // ->where('FechSalida', 'LIKE', '%' . $query4 . '%')
                ->orderBy('r.Estado', 'desc')
                ->orderBy('r.FechReserva', 'desc')
                ->get();
        }
        $datos_hotel = DB::table('datos_hotel')->first();
        $pdf = \PDF::loadView('reserva/listar-registro/listado', ["reserva" => $reserva, "datos_hotel" => $datos_hotel])
            ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }


    public function destroy(Request $request, $id)
    {
        $mytime = Carbon::now('America/Lima');
        DB::beginTransaction();
        try {
            if ($request->ajax()) {
                // Eliminamos los servicios
                $det_servicio = DB::table('detalle_servicio')->where('IdReserva', $id)->delete();
                // Eliminamos Ingreso Caja
                $ingreso_caja = DB::table('ingreso_caja')->where('IdReserva', $id)->delete();

                $acompaniantes = DB::table('huesped_adicional')->where('IdReserva', $id)->delete();
                // Eliminamos los pagos
                $pagos = DB::table('pagos')->where('IdReserva', $id)->delete();
                $reserva   = Reserva::findOrFail($id);
                $pago = Pago_Alter::findOrFail($reserva->IdReserva);

                $pago->delete();
                $reserva->delete();
                // Crear el trigger
                $resp_alquiler = new RespAlquiler();
                $resp_alquiler->IdReserva = $reserva->IdReserva;
                $resp_alquiler->fechEntrada = $reserva->FechEntrada;
                $resp_alquiler->horaEntrada = $reserva->HoraEntrada;
                $resp_alquiler->fechSalida = $reserva->FechSalida;
                $resp_alquiler->horaSalida = $reserva->horaSalida;
                $resp_alquiler->costoAlojamiento = $pago->TotalPago;
                $resp_alquiler->numHab = $reserva->Num_Hab;
                $resp_alquiler->IdCliente = $reserva->IdCliente;
                $resp_alquiler->IdUsuario = auth()->user()->IdUsuario;
                $resp_alquiler->motElim = '.';
                $resp_alquiler->fechElim = $mytime->toDateString();
                $resp_alquiler->horaElim = $mytime->toTimeString();
                $resp_alquiler->save();
                // End Trig

                $Habitacion = Habitacion::findOrFail($reserva->Num_Hab);
                $Habitacion->Estado = "DISPONIBLE";
                $Habitacion->update();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, ' . $e->getMessage(),
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
        ]);
    }

    // public function trigger_delete(){

    // }

    public static function cont_consumo($id)
    {
        $consumo = Consumo::where('IdReserva', $id)->count();
        return $consumo > 0 ? false : true;
    }
    public static function duplicidad_alquiler($num_hab)
    {
        $registro = Reserva::where('Num_Hab', $num_hab)->where('Estado', 'HOSPEDAR')->first();
        return $registro ? true : false;
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
