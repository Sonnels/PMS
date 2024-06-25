<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Consumo;
use App\Datos;
use App\Producto;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ConsumoFormRequest;
use Illuminate\Support\Facades\DB;
use  Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ConsumoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $reserva = DB::table('reserva as r')
                ->join('habitacion as h', 'r.Num_Hab', '=', 'h.Num_Hab')
                ->join('tipohabitacion as th', 'h.IdTipoHabitacion', '=', 'th.IdTipoHabitacion')
                ->join('cliente as c', 'r.IdCliente', 'c.IdCliente')
                ->select('r.Num_Hab', 'th.Denominacion', 'r.IdReserva', 'r.Estado', 'c.Nombre')
                ->where('r.Estado', '=', 'HOSPEDAR')
                ->orderBy('Num_Hab')
                ->paginate(15);
            return view('ventas.consumo.index', ["reserva" => $reserva]);
        }
    }
    public function create()
    {
    }

    public function store(ConsumoFormRequest $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
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
                'precioHora',
                'precioNoche',
                'precioMes',
                'h.Precio as prehab',
                'th.Denominacion',
                'departure_date',
                'c.Nombre as nomcli',
                'servicio'
            )
            ->where('r.IdReserva', '=', $id)
            ->first();
        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();

        $producto = DB::table('producto')
            ->where('IdCategoria', '!=', 1)
            ->get();

        $datos_empresa = Datos::first();
        return view("ventas.consumo.edit", ["reserva" => $reserva, "producto" => $producto, "datos_empresa" => $datos_empresa, "caja" => $caja]);
    }

    public function update(ConsumoFormRequest $request, $id)
    {

        DB::beginTransaction();
        try {
            $caja = DB::table('caja')->where('montoCierre', null)->first();
            $mytime = Carbon::now('America/Lima');
            $idproducto = $request->get('idproducto');
            $cantidad = $request->get('cantidad');
            $precio_venta = $request->get('precio_venta');
            $consumo = $request->get('detalle');
            $estado = $request->get('Estado');
            $metodoPago = $request->get('metodoPago');
            // $nroCuenta = $request->get('nroCuenta');
            $producto = DB::table('producto')->get();
            // strval($idproducto[$cont_0])
            $cont_0 = 0;
            $arr = array();
            foreach ($producto as $pro) {
                $arr[strval($pro->IdProducto)] = $pro->stock;
            }
            while ($cont_0 < count($idproducto)) {
                $arr[strval($idproducto[$cont_0])] = $arr[strval($idproducto[$cont_0])] - $cantidad[$cont_0];
                if ($arr[strval($idproducto[$cont_0])] < 0) {
                    Session::flash('error', 'e');
                    return Redirect::to('ventas/consumo/' . $id . '/edit');
                }
                $cont_0 = $cont_0 + 1;
            }
            $cont = 0;
            while ($cont < count($idproducto)) {
                $consumo = new Consumo();
                $consumo->IdReserva = $id;
                $consumo->IdProducto = $idproducto[$cont];
                $consumo->FechConsumo = $mytime->toDateTimeString();
                $consumo->Cantidad = $cantidad[$cont];
                $consumo->Total = $precio_venta[$cont];
                $consumo->precioVenta = $precio_venta[$cont] / $cantidad[$cont];
                $consumo->Estado = $estado;

                // $consumo->nroCuenta = $nroCuenta;
                if ($estado == 'PAGADO') {
                    $consumo->metodoPago = $metodoPago;
                    $consumo->FechaPago = $mytime->toDateTimeString();
                    $consumo->codCaja =  $caja->codCaja;
                }
                $consumo->IdUsuario = auth()->user()->IdUsuario;
                $consumo->save();

                // Actualizamos el stock de los productos
                $Producto = Producto::findOrFail($idproducto[$cont]);
                $Producto->stock = $Producto->stock - $cantidad[$cont];
                $Producto->update();
                // ------------------------------------------------
                $cont = $cont + 1;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            //throw $th;
            return redirect()->back()->with('error', '¡Error!, ' . $e->getMessage());
        }
        return Redirect::to('ventas/consumo')->with(['success' => 'Se realizó la venta correctamente.']);
    }
    public function destroy(Request $request, $id)
    {
    }
}
