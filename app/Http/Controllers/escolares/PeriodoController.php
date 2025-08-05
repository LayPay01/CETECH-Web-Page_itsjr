<?php

namespace App\Http\Controllers\escolares;

use App\Http\Controllers\Controller;
use App\Models\Periodo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // * Obtiene toda la lista de los periodos
    public function getPeriodos()
    {
        $periodos = Periodo::all();
        return view('escolares.periodos', compact('periodos'));
    }

    // * Obtiene la lista de estatus menos si ya existe alguno "En Curso"
    public function getEstatusDePeriodos()
    {
        $estatus = Periodo::pluck('estatus');
        return response()->json($estatus);
    }

    // * Función para crear un nuevo periodo
    public function createPeriodo(Request $request)
    {
        try {
            $request->validate([
                'txtClave' => 'required',
                'txtNombre' => 'required|string',
                'txtEstatus' => 'required|string',
                // Agrega más reglas de validación para otros campos aquí
                // los 'txt' vienen de la vista
            ]);

            // ? Crea un nuevo plan
            $periodo = new Periodo();
            $periodo->clave_periodo = $request->txtClave;
            $periodo->nombre_periodo = $request->txtNombre;
            $periodo->estatus = $request->txtEstatus;

            $periodo->save(); //Guardamos
            
            return back()->with("Correcto", "Periodo agregado correctamente");
        
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with("Incorrecto", "ERROR - Esa clave del periodo ya existe");
            }
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al agregar el periodo");
        }
    }

    // * Función para eliminar un periodo
    public function deletePeriodo($id)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // ? Buscamos el plan de estudio
            $periodo = Periodo::findOrFail($id);
            // ? Se elimina
            $periodo->delete();

            return back()->with("Correcto", "Se ha eliminado el periodo correctamente");
        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al eliminar el periodo");
        }
    }

    // * Función para actualizar los datos de un periodo
    public function updatePeriodo(Request $request, $id)
    {
        //$data = $request->all();
        //return $request;
        try{
            $periodo = Periodo::findOrFail($id);
            $periodo->estatus = $request->txtEstatus;
    
            $periodo->save();
            return back()->with("Correcto", "Periodo Modificado Correctamente");
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                return back()->with('Incorrecto', 'Error al modificar, la clave del periodo ya existe');
            }
            return back()->with('Incorrecto', 'Error al modificar');
        }
    }
}
