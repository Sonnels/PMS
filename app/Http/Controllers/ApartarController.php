<?php

namespace App\Http\Controllers;

use App\Apartar;
use App\Cliente;
use App\Habitacion;
use App\Http\Requests\ApartarFormRequest;
use App\Http\Requests\ReservaFormRequest;
use App\Pago;
use App\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ReservaController as RC;
use App\TipoDocumento;

class ApartarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $searchText = trim($request->get('searchText'));

            $habitacion = DB::table('habitacion as h')->join('tipohabitacion as t', 'h.idTipoHabitacion', 't.idTipoHabitacion')
                ->where('Estado', '!=', 'MANTENIMIENTO')->get();
            $habitaciones = [];
            foreach ($habitacion as $item) {
                $habitaciones[] = array("id" => $item->Num_Hab, "title" => $item->Num_Hab, "tipo" => $item->Denominacion);
            }
            $cliente = Cliente::orderByDesc('IdCliente')->get();
            // $habitaciones = json_encode($habitaciones);
            $tipo_documento = TipoDocumento::all();
            return view('apartar.index', compact("searchText", "habitaciones", "cliente", "tipo_documento"));
        }
    }

    public function listar()
    {

        $registro = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->join('cliente as c', 'r.IdCliente', 'c.IdCliente')
            ->select('r.IdReserva', 'r.IdCliente', 'Num_Hab', 'FechReserva', 'FechSalida', 'HoraEntrada', 'horaSalida', 'Nombre', 'r.Estado',
             'p.horaSalida_o', 'p.FechaEmision', 'r.entry_date', 'p.departure_date')
            ->get();
        $apartar = DB::table('apartar as a')->join('cliente as c', 'a.IdCliente', 'c.IdCliente')->get();

        $registros = [];
        foreach ($registro as $value) {
            $color = "#17a2b8";
            // $horaSalida = $value->horaSalida;
            // $fechaSalida = $value->FechSalida;
            // -----------------------------
            if ($value->Estado == 'H. CULMINADO') {
                $color = "#9D9FA0";
                // $horaSalida = $value->horaSalida_o;
                // $fechaSalida = $value->FechaEmision;
            } elseif ($value->Estado == 'HOSPEDAR') {
                $color = "#FE6262";
            } elseif ($value->Estado == 'RESERVAR') {
                $color = "#58AAE0";
            }

            $registros[] = [
                "id" => $value->IdReserva,
                "resourceId" => $value->Num_Hab,
                "start" => $value->entry_date,
                "end" => $value->departure_date,
                "title" => $value->Nombre,
                "backgroundColor" => $color,
                "textColor" => "#fff",
                "extendedProps" => [
                    "Num_Hab" => $value->Num_Hab,
                    "IdCliente" => $value->IdCliente,
                    "estado" => 'alquiler'
                ]
            ];
        }
        // Cargamos las reservas
        foreach ($apartar as $item) {
            $color = "#58AAE0";
            $registros[] = [
                "id" => $item->idApartar,
                "resourceId" => $item->Num_Hab,
                "start" => $item->fecIn,
                "end" => $item->fecOut,
                "title" => $item->Nombre,
                "backgroundColor" => $color,
                "textColor" => "#fff",
                "extendedProps" => [
                    "Num_Hab" => $item->Num_Hab,
                    "IdCliente" => $item->IdCliente,
                    "estado" => 'reserva'
                ]
            ];
        }
        return response()->json($registros);
    }


    public function guardar(ApartarFormRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(array(
                    'success' => false,
                    'message' => 'There are incorect values2 in the form!',
                    'errors' => $validator->getMessageBag()->toArray()
                ), 422);
            }

            $this->throwValidationException(
                $request,
                $validator
            );
        }

        $in = $request->all();
        try {
            $validarFecha = $this->validarFecha(-1, $in["Num_Hab"], $in["FechReserva"], $in["HoraEntrada"], $in["FechSalida"], $in["horaSalida"], 'a');

            if (!$validarFecha) {
                $agenda = Apartar::create([
                    "fecIn" => $in["FechReserva"] . ' ' . $in["HoraEntrada"],
                    "horIn" => $in["HoraEntrada"],
                    "fecOut" => $in["FechSalida"] . ' ' . $in["horaSalida"],
                    "horOut" => $in["horaSalida"],
                    "IdCliente" => $in["IdCliente"],
                    "Num_Hab" => $in["Num_Hab"],
                    "IdUsuario" =>  auth()->user()->IdUsuario
                ]);

                return response()->json(['success' => true, "message" => '¡Satisfactorio!, Registro agregado con éxito.']);
            } else {
                return response()->json(['status' => 'error', "message" => '¡Advertencia!, fecha y/o hora no disponibles.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, "message" => $e->getMessage()]);
        }
    }

    public function editar(ApartarFormRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(array(
                    'success' => false,
                    'message' => 'There are incorect values2 in the form!',
                    'errors' => $validator->getMessageBag()->toArray()
                ), 422);
            }

            $this->throwValidationException(
                $request,
                $validator
            );
        }

        $in = $request->all();
        try {
            $validarFecha = $this->validarFecha($in["idApartar"], $in["Num_Hab"], $in["FechReserva"], $in["HoraEntrada"], $in["FechSalida"], $in["horaSalida"], 'a');

            if (!$validarFecha) {
                $apartar = Apartar::findOrfail($in["idApartar"]);
                $apartar->fecIn = $in["FechReserva"] . ' ' . $in["HoraEntrada"];
                $apartar->horIn = $in["HoraEntrada"];
                $apartar->fecOut = $in["FechSalida"] . ' ' . $in["horaSalida"];
                $apartar->horOut = $in["horaSalida"];
                $apartar->IdCliente = $in["IdCliente"];
                $apartar->Num_Hab = $in["Num_Hab"];
                $apartar->IdUsuario = auth()->user()->IdUsuario;
                $apartar->update();

                return response()->json(['success' => true, "message" => '¡Satisfactorio!, Registro Modificado.']);
            } else {
                return response()->json(['status' => 'error', "message" => '¡Advertencia!, fecha y/o hora no disponibles.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, "message" => $e->getMessage()]);
        }
    }

    public function alquilar(ApartarFormRequest $request)
    {
        $caja = DB::table('caja')->where('montoCierre', null)->first();
        DB::beginTransaction();

        if ( RC::duplicidad_alquiler($request->get('Num_Hab'))) {
            return response()->json(['status' => 'error', "message" => '¡Advertencia!, Habitación ocupada.']);
            // return redirect()->back()->with("error", "¡Advertencia!, Se encontró que la habitación " . $request->get('Num_Hab') . " ya está ocupada.");
        }


        try{
            $in = $request->all();
            $validarFecha = $this->validarFecha($in["idApartar"], $in["Num_Hab"], $in["FechReserva"], $in["HoraEntrada"], $in["FechSalida"], $in["horaSalida"], 'a');
            if (!$validarFecha) {
                $registro = new Reserva();
                $registro->FechReserva = $request->get('FechReserva');
                $registro->FechEntrada = $request->get('FechReserva');
                $registro->HoraEntrada = $request->get('HoraEntrada');
                // ----------------------------------------------------------
                $registro->entry_date = $request->get('FechReserva') . ' ' . $request->get('HoraEntrada');
                $registro->FechSalida = $request->get('FechSalida');
                $registro->CostoAlojamiento = 0;
                $registro->descuento = 0;
                $registro->Observacion = '';
                $registro->Estado = 'HOSPEDAR';
                $registro->horaSalida = $request->get('horaSalida');
                $registro->cantMes = 1;
                $registro->metodoPago = 'EFECTIVO';
                $registro->IdCliente = $request->get('IdCliente');
                $registro->Num_Hab = $request->get('Num_Hab');
                $registro->IdUsuario = auth()->user()->IdUsuario;
                $registro->regPago = false;
                $registro->save();
                // Creamos el pago en 0
                $pago = new Pago();
                $mytime = Carbon::now('America/Lima');
                $pago->FechaPago = $mytime->toDateTimeString();
                $pago->departure_date = $request->get('FechSalida') . ' ' . $request->get('horaSalida');
                $pago->TotalPago = 0;
                $pago->Estado = "FALTA PAGAR";
                $pago->IdReserva = $registro->IdReserva;
                $pago->codCaja = $caja->codCaja;
                // -------------------------------------
                $habitacion = Habitacion::findOrfail($request->get('Num_Hab'));
                if ($habitacion->Estado != 'DISPONIBLE') {
                    return response()->json(['status' => "error", "message" => '¡Error!, La Habitación no se encuentra DISPONIBLE.']);
                }
                $habitacion->Estado = 'OCUPADO';
                $habitacion->update();
                DB::commit();
            }else{
                return response()->json(['status' => 'error', "message" => '¡Advertencia!, fecha y/o hora no disponibles.']);
                // return response()->json(['status' => 'error', "message" => $validarFecha]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => "error", "message" => $e->getMessage()]);
        }

        if ($pago->save()) {
            $apartar = Apartar::findOrfail($request->get('idApartar'));
            $apartar->delete();
            return response()->json(['success' => true, "message" => '¡Satisfactorio!, Alquiler Registrado.']);
        }else{
            return response()->json(['status' => "error", "message" => '¡Error!, No se pudo Registrar.']);
        }

    }

    public function eliminar(Request $request)
    {
        $in = $request->all();
        $apartar = Apartar::findOrfail($in["idApartar"]);
        if ($apartar->delete()) {
            return response()->json( [
                'success' => true,
                'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
            ] );
        }else {
            return response()->json( [
                'success' => false,
                'message' => '¡Error!, No se pudo eliminar.',
            ] );
        }
    }

    public static function validarFecha($id, $num_hab, $fechaIn, $horaInicial, $fechaOut, $horaFinal, $t)
    {
        $id_agenda = $t == 'r' ? $id : -1;
        $id_apartar = $t == 'a' ? $id : -1;

        // Formateasmos las fechas
        // $fechaIn = date($fechaIn . ' ' . $horaInicial);
        // $fechaOut = date($fechaOut . ' ' . $horaFinal);
        $fechaIn = $fechaIn . ' ' . $horaInicial;
        $fechaOut = $fechaOut . ' ' . $horaFinal;
        // $prueba = date('$fechaOut');

        // $agenda = Reserva::where('Num_Hab', $num_hab)
        //     ->where('IdReserva', '!=', $id_agenda)
        //     ->where('Estado', '!=', 'H. CULMINADO')
        //     ->Where(function ($q)  use ($fechaIn, $fechaOut) {
        //         $q->orwhereBetween('FechEntrada', [$fechaIn, $fechaOut])
        //             ->orWhereBetween('FechSalida', [$fechaIn, $fechaOut]);
        //     })
        //     ->Where(function ($q)  use ($horaInicial, $horaFinal) {
        //         $q->whereBetween('HoraEntrada', [$horaInicial, $horaFinal])
        //             ->orWhereBetween('horaSalida', [$horaInicial, $horaFinal]);
        //     })
        //     ->first();

        // Agendas culminadas
        $agenda2 = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->where('r.Num_Hab', $num_hab)
            ->where('r.IdReserva', '!=', $id_agenda)

            // ->where('r.Estado', 'H. CULMINADO')

            // ->Where(function ($q)  use ($fechaIn, $fechaOut) {
            //     $q->orwhereBetween('r.FechEntrada', [$fechaIn, $fechaOut])
            //         ->orWhereBetween('p.FechaEmision', [$fechaIn, $fechaOut]);
            // })
            // ->Where(function ($q)  use ($horaInicial, $horaFinal) {
            //     $q->orwhereBetween('r.HoraEntrada', [$horaInicial, $horaFinal])
            //         ->orWhereBetween('p.horaSalida_o', [$horaInicial, $horaFinal]);
            // })

            // ->Where(function ($q)  use ($fechaIn, $fechaOut) {
            //     $q->whereBetween('r.entry_date', [$fechaIn, $fechaOut])
            //         ->orWhereBetween('p.departure_date', [$fechaIn, $fechaOut]);
            // })
            ->where('p.departure_date', '>=', $fechaIn)
            ->where('r.entry_date', '<=', $fechaOut)
            ->first();



        // return $agenda;

        $apartar = Apartar::where('Num_Hab', $num_hab)
            ->where('idApartar', '!=', $id_apartar)

            // ->Where(function ($q)  use ($horaInicial, $horaFinal) {
            //     $q->orwhereBetween('horIn', [$horaInicial, $horaFinal])
            //         ->orWhereBetween('horOut', [$horaInicial, $horaFinal]);
            // })
            // ->Where(function ($q)  use ($fechaIn, $fechaOut) {
            //     $q->whereBetween('fecIn', [$fechaIn, $fechaOut])
            //         ->orWhereBetween('fecOut', [$fechaIn, $fechaOut]);
            // })
            ->where('fecOut', '>=', $fechaIn)
            ->where('fecIn', '<=', $fechaOut)
            ->first();
        // return $apartar;
        // return $agenda == null && $apartar == null ? true : false;
        // return $apartar || $agenda || $agenda2 ? true : false;
        return $apartar || $agenda2 ? true : false;
    }
}
