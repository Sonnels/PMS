<?php

namespace App\Http\Controllers;

use App\DetLimpieza;
use App\Personal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->componentName = "Personal";
    }
    public function index(Request $request)
    {
        $componentName =  $this->componentName;
        if ($request) {
            $query = trim($request->get('searchText'));
            $personal = Personal::where('nomPer', 'LIKE', '%' . $query . '%')
            ->orderBy('nomPer')
            ->paginate(7);
            return view('acceso.personal.index', ["personal" => $personal, "searchText" => $query, "componentName"=>$componentName]);
        }
    }

    public function store(Request $request)
    {

        try {
            $personal = new Personal();
            $personal->nomPer = $request->get('nomPer');
            $personal->telPer = $request->get('telPer');
            $personal->save();
            return Redirect::to('acceso/personal')->with(['success' => $personal->nomPer . ' agregado']);
        } catch (Exception $e) {
            return Redirect::to('acceso/personal')->with(['error' => $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        return view("acceso.personal.edit", ["componentName" => $this->componentName, "personal" => Personal::findOrFail($id)]);
    }
    public function update(Request $request, $id)
    {
        try {
            $personal = Personal::findOrFail($id);
            $personal->nomPer = $request->get('nomPer');
            $personal->telPer = $request->get('telPer');
            $personal->update();
            return Redirect::to('acceso/personal')->with(['success' => $personal->nomPer . ' modificado']);
        } catch (Exception $e) {
            return Redirect::to('acceso/personal')->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $personal = Personal::findOrFail($id);

                if ($personal->delete()) {
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
                    'message' => '¡Error!, ' . $e->getMessage(),
                ]);
            }
        }
    }

    public static function validate_destroy($id){
        $det_limpieza = DetLimpieza::where('idPer', $id)->first();
        return $det_limpieza ? false : true;
    }

}
