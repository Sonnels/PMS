<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use App\Http\Requests\AperturaCierreFormRequest;
use App\AperturaCierre;
use App\Datos;

class AperturaCierreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $registro = DB::table('caja')->where('montoCierre', null)->first();
            $datos_hotel = Datos::first();
            // $caja = DB::table('caja')->where('codCaja', $query)->first();
            return view('caja.apertura.index', ["searchText" => $query, "registro" => $registro, "datos_hotel"=> $datos_hotel]);
        }
    }

    public function store(AperturaCierreFormRequest $request)
    {
        $caja = new AperturaCierre();
        $mytime = Carbon::now('America/Lima');
        $caja->horaApertura = $mytime->toTimeString();
        $caja->fechaApertura = $mytime->toDateString();
        $caja->montoApertura = $request->get('montoApertura');
        $caja->codUsuario = auth()->user()->IdUsuario;
        $caja->save();
        return redirect()->back()->with(['flash' =>  'Caja Aperturada Correctamente']);
    }

    public function update(AperturaCierreFormRequest $request, $id)
    {
        $caja = AperturaCierre::findOrFail($id);
        $mytime = Carbon::now('America/Lima');
        $caja->horaCierre = $mytime->toTimeString();
        $caja->fechaCierre = $mytime->toDateString();
        $caja->montoCierre = $request->get('montoCierre');
        $caja->update();
        return redirect()->back()->with(['success' =>  $id]);
    }

    public static function fechaCastellano($fecha)
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
        // return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
        return $nombredia . " " . $numeroDia . " de " . $nombreMes;
    }

    public function reportPdf($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();

        $caja = DB::table('caja as c')
            ->join('usuario as u', 'c.codUsuario', 'u.IdUsuario')
            ->where('codCaja', $id)->first();

        $fechaCierre = $caja->fechaCierre == null ? $mytime->toDateString() : $caja->fechaCierre;
        $horaCierre = $caja->horaCierre == null ? $mytime->toTimeString() : $caja->horaCierre;
        $registro = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->select(DB::raw('SUM(TotalPago) as pago'))
            ->where('codCaja', $caja->codCaja)
            ->where('r.metodoPago', 'EFECTIVO')
            ->first();

        $registro_BDigital = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->select(DB::raw('SUM(TotalPago) as pago'))
            ->where('codCaja', $caja->codCaja)
            ->where('metodoPago', 'B. DIGITAL')
            ->first();

        $registro_TCredito = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->select(DB::raw('SUM(TotalPago) as pago'))
            ->where('codCaja', $caja->codCaja)
            ->where('metodoPago', 'TARJETA')
            ->first();
        // ------------------------------------------------------
        $renov_efectivo = DB::table('renovacion')
            ->select(DB::raw('SUM(cosRen) as pago'))
            ->where('codCaja', $caja->codCaja)
            ->where('metPagRen', 'EFECTIVO')
            ->first();

        $renov_BDigital = DB::table('renovacion')
            ->select(DB::raw('SUM(cosRen) as pago'))
            ->where('codCaja', $caja->codCaja)
            ->where('metPagRen', 'B. DIGITAL')
            ->first();

        $renov_TCredito = DB::table('renovacion')
            ->select(DB::raw('SUM(cosRen) as pago'))
            ->where('codCaja', $caja->codCaja)
            ->where('metPagRen', 'TARJETA')
            ->first();

        // ------------------------------------------------------

        $post_al_efectivo = DB::table('ingreso_caja')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('motivo','LIKE','%'. 'ALQUILER' .'%')
            ->where('codCaja', $caja->codCaja)
            ->where('metodoPago', 'EFECTIVO')
            ->first();

        $post_al_BDigital = DB::table('ingreso_caja')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('motivo','LIKE','%'. 'ALQUILER' .'%')
            ->where('codCaja', $caja->codCaja)
            ->where('metodoPago', 'B. DIGITAL')
            ->first();

        $post_al_TCredito = DB::table('ingreso_caja')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('motivo','LIKE','%'. 'ALQUILER' .'%')
            ->where('codCaja', $caja->codCaja)
            ->where('metodoPago', 'TARJETA')
            ->first();
        // ---------------------------------------------------

        $penalidad_efectivo = DB::table('ingreso_caja')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('motivo','LIKE','%'. 'PENALIDAD' .'%')
            ->where('codCaja', $caja->codCaja)
            ->where('metodoPago', 'EFECTIVO')
            ->first();

        $penalidad_BDigital = DB::table('ingreso_caja')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('motivo','LIKE','%'. 'PENALIDAD' .'%')
            ->where('codCaja', $caja->codCaja)
            ->where('metodoPago', 'B. DIGITAL')
            ->first();

        $penalidad_TCredito = DB::table('ingreso_caja')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('motivo','LIKE','%'. 'PENALIDAD' .'%')
            ->where('codCaja', $caja->codCaja)
            ->where('metodoPago', 'TARJETA')
            ->first();

        // ---------------------------------------------
        $pagos_efectivo = DB::table('pagos')->select(DB::raw('SUM(monPag) as total'), 'codCaja')
            ->where('codCaja', $caja->codCaja)
            ->where('metPag', 'EFECTIVO')
            ->groupBy('codCaja')
            ->first();

        $pagos_bgdigital = DB::table('pagos')->select(DB::raw('SUM(monPag) as total'), 'codCaja')
            ->where('codCaja', $caja->codCaja)
            ->where('metPag', 'B. DIGITAL')
            ->groupBy('codCaja')
            ->first();

        $pagos_TCredito = DB::table('pagos')->select(DB::raw('SUM(monPag) as total'), 'codCaja')
            ->where('codCaja', $caja->codCaja)
            ->where('metPag', 'TARJETA')
            ->groupBy('codCaja')
            ->first();


        // -------------------------------------------

        $consu_efectivo = DB::table('consumo as c')->join('reserva as r', 'c.IdReserva', 'r.IdReserva')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->select(DB::raw('SUM(Total) as totalVenta'))
            ->where('c.codCaja', $caja->codCaja)
            ->where('c.metodoPago', 'EFECTIVO')
            ->where('c.Estado', 'PAGADO')
            ->where('IdCategoria', '!=', 1)
            ->first();

        $consu_bdigital = DB::table('consumo as c')->join('reserva as r', 'c.IdReserva', 'r.IdReserva')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->select(DB::raw('SUM(Total) as totalVenta'))
            ->where('c.codCaja', $caja->codCaja)
            ->where('c.metodoPago', 'B. DIGITAL')
            ->where('c.Estado', 'PAGADO')
            ->where('IdCategoria', '!=', 1)
            ->first();

        $consu_tarjeta = DB::table('consumo as c')->join('reserva as r', 'c.IdReserva', 'r.IdReserva')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->select(DB::raw('SUM(Total) as totalVenta'))
            ->where('c.codCaja', $caja->codCaja)
            ->where('c.metodoPago', 'TARJETA')
            ->where('c.Estado', 'PAGADO')
            ->where('IdCategoria', '!=', 1)
            ->first();
        // -------------------------------------------------

        $servi_efectivo = DB::table('consumo as c')->join('reserva as r', 'c.IdReserva', 'r.IdReserva')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->select(DB::raw('SUM(Total) as totalVenta'))
            ->where('c.codCaja', $caja->codCaja)
            ->where('c.metodoPago', 'EFECTIVO')
            ->where('c.Estado', 'PAGADO')
            ->where('IdCategoria', 1)
            ->first();

        $servi_bdigital = DB::table('consumo as c')->join('reserva as r', 'c.IdReserva', 'r.IdReserva')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->select(DB::raw('SUM(Total) as totalVenta'))
            ->where('c.codCaja', $caja->codCaja)
            ->where('c.metodoPago', 'B. DIGITAL')
            ->where('c.Estado', 'PAGADO')
            ->where('IdCategoria', 1)
            ->first();

        $servi_tarjeta = DB::table('consumo as c')->join('reserva as r', 'c.IdReserva', 'r.IdReserva')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->select(DB::raw('SUM(Total) as totalVenta'))
            ->where('c.codCaja', $caja->codCaja)
            ->where('c.metodoPago', 'TARJETA')
            ->where('c.Estado', 'PAGADO')
            ->where('IdCategoria', 1)
            ->first();

        // -------------------------------------------------

        $v_otro_efectivo = DB::table('venta')->select(DB::raw('SUM(totalVenta) as totalVenta'))
            ->where('codCaja', $caja->codCaja)->where('metodoPago', 'EFECTIVO')
            ->first();

        $v_otro_bdigital = DB::table('venta')->select(DB::raw('SUM(totalVenta) as totalVenta'))
            ->where('codCaja', $caja->codCaja)->where('metodoPago', 'B. DIGITAL')
            ->first();

        $v_otro_tarjeta = DB::table('venta')->select(DB::raw('SUM(totalVenta) as totalVenta'))
            ->where('codCaja', $caja->codCaja)->where('metodoPago', 'TARJETA')
            ->first();

        $servicio = DB::table('detalle_servicio as ds')->join('reserva as r', 'ds.IdReserva', 'r.IdReserva')
            ->join('pago as p', 'r.idReserva', 'p.idReserva')
            ->select(DB::raw('SUM(precioDS) as precioDS'))
            ->where('ds.codCaja', $caja->codCaja)
            ->first();

        $ingreso = DB::table('ingreso_caja')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('motivo','NOT LIKE','%'. 'ALQUILER' .'%')
            ->where('motivo','NOT LIKE','%'. 'PENALIDAD' .'%')
            ->where('estado', 'APROBADO')
            ->where('codCaja', $caja->codCaja)
            ->first();

        $egreso = DB::table('egreso_caja')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('estado', 'APROBADO')
            ->where('codCaja', $caja->codCaja)
            ->first();



        $producto = DB::table('detalle_venta as dv')->join('venta as v', 'dv.codVenta', 'v.codVenta')
            ->join('producto as p', 'dv.IdProducto', 'p.IdProducto')
            ->where('v.codCaja', $caja->codCaja)
            ->get();

        $ingreso_detallado = DB::table('ingreso_caja')
            ->where('motivo', '!=', 'ALQUILER')
            ->where('motivo', '!=', 'PENALIDAD')
            ->where('estado', 'APROBADO')
            ->where('codCaja', $caja->codCaja)
            ->get();

        $egreso_detallado = DB::table('egreso_caja')
            ->where('estado', 'APROBADO')
            ->where('codCaja', $caja->codCaja)
            ->orderBy('tipo')
            ->get();

        $pdf = \PDF::loadView('caja.apertura.report', ["caja" => $caja,
            "consu_efectivo" => $consu_efectivo, "consu_bdigital"=>$consu_bdigital, "consu_tarjeta"=>$consu_tarjeta,
            "servi_efectivo" => $servi_efectivo, "servi_bdigital"=>$servi_bdigital, "servi_tarjeta"=>$servi_tarjeta,
            "v_otro_efectivo" => $v_otro_efectivo, "v_otro_bdigital"=>$v_otro_bdigital, "v_otro_tarjeta" => $v_otro_tarjeta,
            "ingreso" => $ingreso,
            "registro" => $registro,  "registro_BDigital" => $registro_BDigital, "registro_TCredito" => $registro_TCredito,
            "pagos_efectivo" => $pagos_efectivo, "pagos_bgdigital" => $pagos_bgdigital, "pagos_TCredito"=> $pagos_TCredito,
            "renov_efectivo" => $renov_efectivo, "renov_BDigital" => $renov_BDigital, "renov_TCredito" => $renov_TCredito,
            "egreso" => $egreso, "producto" => $producto, "fechaHora" => $fechaHora, "servicio" => $servicio,
            "post_al_efectivo" => $post_al_efectivo, "post_al_BDigital" => $post_al_BDigital, "post_al_TCredito" => $post_al_TCredito,
            "penalidad_efectivo" => $penalidad_efectivo, "penalidad_BDigital" => $penalidad_BDigital, "penalidad_TCredito" => $penalidad_TCredito,
            "ingreso_detallado" => $ingreso_detallado, "egreso_detallado" => $egreso_detallado
        ])
            ->setPaper(array(0, 0, 204, 750));
        return $pdf->stream('Arqueo de Caja #' . $caja->codCaja . '.pdf');
    }

    public function reportPdf2($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        $caja = DB::table('caja as c')->join('usuario as u', 'c.codUsuario', 'u.IdUsuario')->where('codCaja', $id)->first();
        $datos_hotel = Datos::first();

        // $producto = DB::table('sales_details as dv')
        // ->join('sales as v', 'dv.idSales', 'v.idSales')
        // ->join('products as p', 'dv.idProducts', 'p.idProducts')
        // ->select('nameProducts','priceSales_details', DB::raw('SUM(dv.quantity) as quantity'), DB::raw('SUM(dv.discount) as discount'))
        // ->where('idBox', $caja->idBox)
        // ->groupBy('dv.idProducts', 'priceSales_details', 'nameProducts')
        // ->orderByDesc('quantity')
        // ->get();

        $consumo = DB::table('consumo as c')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
            ->select('c.IdProducto', 'NombProducto', 'precioVenta', 'Denominacion', DB::raw('SUM(Cantidad) as Cantidad'))
            ->where('codCaja', $id)
            ->where('metodoPago', '!=', 'CORTESÍA')
            ->groupBy('c.IdProducto', 'precioVenta', 'NombProducto', 'Denominacion')
            ->get();

        $cor_consumo = DB::table('consumo as c')
            ->join('producto as p', 'c.IdProducto', 'p.IdProducto')
            ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
            ->select('c.IdProducto', 'NombProducto', 'precioVenta', 'Denominacion', DB::raw('SUM(Cantidad) as Cantidad'))
            ->where('codCaja', $id)
            ->where('metodoPago', 'CORTESÍA')
            ->groupBy('c.IdProducto', 'precioVenta', 'NombProducto', 'Denominacion')
            ->get();

        $producto = DB::table('detalle_venta as dv')
            ->join('venta as v', 'dv.codVenta', 'v.codVenta')
            ->join('producto as p', 'dv.IdProducto', 'p.IdProducto')
            ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
            ->select('dv.IdProducto', 'NombProducto', 'precioVenta',  'Denominacion', DB::raw('SUM(dv.Cantidad) as Cantidad'))
            ->where('codCaja', $id)
            ->where('metodoPago', '!=', 'CORTESÍA')
            ->groupBy('dv.IdProducto', 'precioVenta', 'NombProducto', 'Denominacion')
            ->get();

        $cor_producto = DB::table('detalle_venta as dv')
            ->join('venta as v', 'dv.codVenta', 'v.codVenta')
            ->join('producto as p', 'dv.IdProducto', 'p.IdProducto')
            ->join('categoria as ca', 'p.IdCategoria', 'ca.IdCategoria')
            ->select('dv.IdProducto', 'NombProducto', 'precioVenta',  'Denominacion', DB::raw('SUM(dv.Cantidad) as Cantidad'))
            ->where('codCaja', $id)
            ->where('metodoPago', 'CORTESÍA')
            ->groupBy('dv.IdProducto', 'precioVenta', 'NombProducto', 'Denominacion')
            ->get();

        $pdf = \PDF::loadView('caja.apertura.report2', ["caja" => $caja, "datos_hotel" => $datos_hotel, "consumo" => $consumo,
        "cor_consumo" => $cor_consumo,
        "producto"=>$producto, "cor_producto"=>$cor_producto, "fechaHora"=>$fechaHora]);
        // ->setPaper('a4', 'landscape');
        return $pdf->stream('Corte de Turno #' . $caja->codCaja . '.pdf');
    }
}
