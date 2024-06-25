<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Reserva;
use App\Pago;
use App\Habitacion;
use App\Consumo;
use App\DetalleServicio;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ReservaFormRequest;
use App\IngresoCaja;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class SalidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
       if($request)
        {
            // $query = trim ($request -> get('searchText'));
            // $Categoria = DB::table('Categoria')->where('Denominacion','LIKE','%'.$query.'%')
            // ->orderBy('IdCategoria','desc')
            $mytime = Carbon::now('America/Lima');
            $fecha_hora =  $mytime->toDateTimeString();

            $reserva = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')
            ->join('tipohabitacion as th', 'h.IdTipoHabitacion', '=', 'th.IdTipoHabitacion')
            ->join('cliente as c', 'r.IdCliente', 'c.IdCliente')
            ->select('r.Num_Hab', 'th.Denominacion', 'r.IdReserva', 'r.Estado', 'FechSalida', 'c.Nombre', 'departure_date')
            ->where('r.Estado', '=','HOSPEDAR')
            ->orderBy('Num_Hab')
            ->paginate(15);
          return view('salidas.verificacion.index',["reserva"=>$reserva, "fecha_hora"=>$fecha_hora]);
          }
    // echo"hola";
    }


    public function edit($id){
        $reserva=DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', '=', 'r.IdReserva')
            ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')
            ->join('cliente as c', 'r.IdCliente', '=', 'c.IdCliente')
            ->join('usuario as u', 'r.IdUsuario', '=', 'u.IdUsuario')
            ->join('tipohabitacion as th', 'h.IdTipoHabitacion', '=', 'th.IdTipoHabitacion')
            ->select('r.IdReserva', 'r.IdCliente', 'FechEntrada','FechSalida', 'c.NumDocumento as Ndcliente', 'horaSalida',
            'CostoAlojamiento','Observacion', 'r.Estado as EsReser', 'c.Celular', 'c.Direccion',
            'r.Num_Hab', 'u.NumDocumento', 'u.Nombre', 'r.Descuento', 'r.toalla', 'precioHora', 'precioHora6', 'precioHora8', 'precioNoche', 'precioMes',
            'h.Precio as prehab', 'th.Denominacion', 'p.IdPago','p.TotalPago', 'p.Pago2', 'r.servicio',
            'c.Nombre as nomcli', 'c.Apellido as apecli', 'departure_date')
            ->where('r.IdReserva', '=', $id)
            ->first();

        $renovacion = DB::table('renovacion')->select(DB::raw('SUM(cosRen) - SUM(descuentoRen) as total'), 'IdReserva')
            ->groupBy('IdReserva')
            ->where('IdReserva', $id)
            ->first();

        $pagos = DB::table('pagos')->select(DB::raw('SUM(monPag) as total'), 'IdReserva')
            ->where('IdReserva', $id)
            ->groupBy('IdReserva')
            ->first();

        $consumo=DB::table('consumo as c')
            ->join('producto as p', 'c.IdProducto', '=', 'p.IdProducto')
            ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
            ->where('IdReserva', '=', $id)
            ->get();
        $servicio=DetalleServicio::where('IdReserva', $id)->select(DB::raw('SUM(precioDS * cantidadDS) as precioDS'))->first();
        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();

        return view("salidas.verificacion.edit",["reserva"=>$reserva,"consumo"=>$consumo, "servicio"=>$servicio, "pagos"=>$pagos, "renovacion"=>$renovacion, "caja"=>$caja]);
    }
    public function update(ReservaFormRequest $request, $id){
        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
        if ($request->get('totalporpagar') > 0 && !$caja) {
            return redirect()->back()->with("error", "¡Advertencia!, El Huesped tiene una cuenta pendiente y se detectó que la caja no esta aperturada.");
        }

        try {
            $mytime = Carbon::now('America/Lima');
            $reserva=reserva::findOrFail($id);
            $reserva->Estado=$request->get('Estado');
            $reserva->update();

            $pago = pago::findOrFail($request->get('IdPago'));
            if ($request->get('penalidad') == 0){
                $pago -> Penalidad = 0;
            }else {
                $pago -> Penalidad = $request->get('penalidad');
            }
            if (intval($request->get('porpagar1')) != 0){
                $pago -> Pago2 = $request->get('porpagar1');
            }
            $pago -> Estado = "PAGADO";
            $pago -> FechaEmision = $mytime->toDateString();
            $pago -> horaSalida_o = $mytime->toTimeString();
            // Actualizar fechas;
            $pago -> departure_date = $mytime->toDateTimeString();

            $pago->update();

            $habitacion = Habitacion::findOrFail($request->get('Num_Hab'));
            $habitacion -> Estado = "PARA LIMPIEZA";
            $habitacion->update();

            $consumo = DB::table('consumo')->where('IdReserva', '=', $id)->get();
            foreach ($consumo as $con){
                $consuming = consumo::findOrFail($con->IdConsumo);
                if(!isset($consuming -> FechaPago )){
                    $consuming -> FechaPago = $mytime->toDateTimeString();
                    $consuming -> idUsuario = auth()->user()->IdUsuario;
                    $consuming -> Estado = "PAGADO";
                    $consuming -> codCaja = $caja->codCaja;
                    $consuming -> metodoPago =  $request->get('metodoPago');
                    $consuming->update();
                }
            }
            // Registramos la penalidad
            if ($request->get('penalidad') > 0) {
                $ingreso = new IngresoCaja();
                $ingreso->horaIngreso = $mytime->toTimeString();
                $ingreso->fechaIngreso = $mytime->toDateString();
                $ingreso->recibidoDe = $reserva->IdCliente;
                $ingreso->motivo = 'PENALIDAD';
                $ingreso->importe = $request->get('penalidad');
                $ingreso->estado = 'APROBADO';
                $ingreso->metodoPago =  $request->get('metodoPago');
                $ingreso->IdReserva = $reserva->IdReserva;
                $ingreso->codUsuario = auth()->user()->IdUsuario;
                $ingreso->codCaja =  $caja -> codCaja;
                $ingreso->save();
            }


            // Registramos el pago pendiente
            $pag_pend_reserva = $request->get('totalporpagar') - $request->get('penalidad') - $request->get('porpagarc');
            if ($pag_pend_reserva > 0) {
                $ingreso = new IngresoCaja();
                $ingreso->horaIngreso = $mytime->toTimeString();
                $ingreso->fechaIngreso = $mytime->toDateString();
                $ingreso->recibidoDe = $reserva->IdCliente;
                $ingreso->motivo = 'ALQUILER';
                $ingreso->importe = $pag_pend_reserva;
                $ingreso->estado = 'APROBADO';
                $ingreso->metodoPago =  $request->get('metodoPago');
                $ingreso->IdReserva = $reserva->IdReserva;
                $ingreso->codUsuario = auth()->user()->IdUsuario;
                $ingreso->codCaja =  $caja -> codCaja;
                $ingreso->save();
            }

            return Redirect::to('salidas/verificacion')->with(['success' => 'Salida Correcta, el estado de la habitación ' . $request->get('Num_Hab') . ' se actualizó']);
        } catch (\Exception $e) {
            return redirect()->back()->with("error", "Error!, " . $e->getMessage());
        }

    }

    public function show($id)
    {
    }

    public function destroy(Request $request, $id){
    }

    public static function fechaCastellano ($fecha) {
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
        return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
    }

}

