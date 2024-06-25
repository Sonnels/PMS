<?php

namespace App\Http\Controllers;

use App\Datos;
use App\DetLimpieza;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Habitacion;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\HabitacionFormRequest;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\DB;

class HabitacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        if ($request) {
            $query = trim($request->get('searchText'));
            $Habitacion = DB::table('habitacion as a')
                ->join('nivel as c', 'a.IdNivel', '=', 'c.IdNivel')
                ->join('tipohabitacion as b', 'a.IdTipoHabitacion', '=', 'b.IdTipoHabitacion')
                ->select(
                    'a.Num_Hab',
                    'a.Descripcion',
                    'a.Estado',
                    'a.Precio',
                    'c.Denominacion as Nivel',
                    'b.Denominacion as TipoHabitacion',
                    'precioHora',
                    'precioHora6',
                    'precioHora8',
                    'precioNoche',
                    'precioMes',
                    'resMan',
                    'fecMan',
                    'motMan'
                )
                ->where('a.Descripcion', 'LIKE', '%' . $query . '%')
                ->orwhere('b.Denominacion', 'LIKE', '%' . $query . '%')
                ->orwhere('c.Denominacion', 'LIKE', '%' . $query . '%')
                ->orderBy('c.Denominacion', 'asc')
                ->orderBy('Num_Hab', 'asc')
                ->paginate(10);

            $datos_hotel = Datos::first();

            return view('mantenimiento.habitacion.index', ["Habitacion" => $Habitacion, "searchText" => $query, "fechaHora" => $fechaHora, "datos_hotel"=>$datos_hotel]);
        }
    }
    public function create()
    {
        $Nivel = DB::table('nivel')->get();
        $TipoHabitacion = DB::table('tipohabitacion')->get();

        return view("mantenimiento.habitacion.create", ["TipoHabitacion" => $TipoHabitacion, "Nivel" => $Nivel]);
    }
    public function store(HabitacionFormRequest $request)
    {
        $Habitacion = new Habitacion;
        $Habitacion->Num_Hab = $request->get('Num_Hab');
        $Habitacion->Descripcion = $request->get('Descripcion');
        $Habitacion->Estado = $request->get('Estado');
        $Habitacion->Precio = $request->get('Precio');
        $Habitacion->IdTipoHabitacion = $request->get('IdTipoHabitacion');
        $Habitacion->IdNivel = $request->get('IdNivel');
        $Habitacion->save();
        return Redirect::to('mantenimiento/habitacion')->with(['success' => 'Se agregó la habitación ' . $request->get('Num_Hab')]);
    }
    public function show($id)
    {
        return view("mantenimiento.habitacion.show", ["Habitacion" => Habitacion::findOrFail($id)]);
    }
    public function edit($id)
    {
        $Habitacion = Habitacion::findOrFail($id);
        $TipoHabitacion = DB::table('tipohabitacion')->get();
        $Nivel = DB::table('nivel')->get();
        return view("mantenimiento.habitacion.edit", ["Habitacion" => $Habitacion, "Nivel" => $Nivel, "TipoHabitacion" => $TipoHabitacion]);
    }
    public function update(HabitacionFormRequest $request, $id)
    {
        $Habitacion = Habitacion::findOrFail($id);
        $Habitacion->Num_Hab = $request->get('Num_Hab');
        $Habitacion->Descripcion = $request->get('Descripcion');
        $Habitacion->Estado = $request->get('Estado');
        $Habitacion->Precio = $request->get('Precio');
        $Habitacion->IdTipoHabitacion = $request->get('IdTipoHabitacion');
        $Habitacion->IdNivel = $request->get('IdNivel');
        $Habitacion->update();
        return Redirect::to('mantenimiento/habitacion')->with(['success' => 'Se modificó los datos de la habitación ' .  $Habitacion->Num_Hab . '.']);
    }
    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu   = Habitacion::findOrFail($id);

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
                    'message' => '¡Error!, Este registro tiene asociado uno o mas registros de Reservas.',
                ]);
            }
        }
    }
    public function confHab(Request $request, $id)
    {
        try {
            $habitacion = Habitacion::findOrfail($id);
            $habitacion->Estado = 'MANTENIMIENTO';
            $habitacion->motMan = $request->get('motMan');
            $habitacion->fecMan = $request->get('fecMan');
            $habitacion->resMan = $request->get('resMan');
            $habitacion->update();
            return redirect()->back()->with(["success" => 'Habitación ' . $habitacion->Num_Hab . ' pasó a mantenimiento.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(["error" => $e->getMessage()]);
        }
    }

    public function hablHab($id)
    {
        try {
            $habitacion = Habitacion::findOrfail($id);
            $habitacion->Estado = 'DISPONIBLE';
            $habitacion->motMan = null;
            $habitacion->fecMan = null;
            $habitacion->resMan = null;
            $habitacion->update();
            return redirect()->back()->with(["success" => 'Habitación ' . $habitacion->Num_Hab . ' cambió de estado a disponible.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(["error" => $e->getMessage()]);
        }
    }

    public function enviar_limpieza(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        try {
            $detLimpieza = new DetLimpieza();
            $detLimpieza->fechaDetLim = $mytime->toDateString();
            $detLimpieza->horaDetLim = $mytime->toTimeString();
            $detLimpieza->idPer = $request->get('idPer');
            $detLimpieza->idLim = $request->get('idLim');
            $detLimpieza->Num_Hab = $request->get('Num_Hab');
            $detLimpieza->save();

            // Cambiar a Limpieza
            $habitacion = Habitacion::findOrfail($detLimpieza->Num_Hab);
            $habitacion->Estado = 'LIMPIEZA';
            $habitacion->idDetLim = $detLimpieza->idDetLim;
            $habitacion->update();
            return redirect()->back()->with(["success" => 'Habitación ' . $detLimpieza->Num_Hab . ' enviada a Limpieza.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(["error" => $e->getMessage()]);
        }
    }

    public static function ged_limpieza($id){
        $data = DB::table('det_limpieza as d')->join('tipo_limpieza as t', 'd.idLim', 't.idLim')
                ->join('personal as p', 'd.idPer', 'p.idPer')
                ->where('idDetLim', $id)
                ->first();
        $minutes_to_add  = $data->tieLim;
        $time = new DateTime( $data->fechaDetLim . ' ' . $data->horaDetLim);
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        return $time->format('Y-m-d H:i:s');
    }

    public static function ged_d_limpieza($id){
        $data = DB::table('det_limpieza as d')->join('tipo_limpieza as t', 'd.idLim', 't.idLim')
            ->join('personal as p', 'd.idPer', 'p.idPer')
            ->where('idDetLim', $id)
            ->first();
        return $data;
    }
}
