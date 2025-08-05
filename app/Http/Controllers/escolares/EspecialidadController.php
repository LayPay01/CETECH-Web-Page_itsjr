<?php

namespace App\Http\Controllers\escolares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Especialidad;
use Illuminate\Database\QueryException;

class EspecialidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // * Función para crear un nuevo Salón
    public function createEspecialidad(Request $request)
    {
        try {
            $request->validate([
                'txtClaveEsp' => 'required',
                'txtEspecialidad' => 'required',
                'txtPlanEstudio' => 'required',
                // Agrega más reglas de validación para otros campos aquí
                // los 'txt' vienen de la vista
            ]);
            
            // ? Crea un salón
            $especialidades = new Especialidad();
            $especialidades->clave_especialidad = $request->txtClaveEsp;
            $especialidades->especialidad = $request->txtEspecialidad;
            $especialidades->plan_estudio_id = $request->txtPlanEstudio;

            $especialidades->save(); //Guardamos
            
            return back()->with("Correcto", "Especialidad agregada correctamente");
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with("Incorrecto", "ERROR - Esa clave de la especialidad ya existe");
            }
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al agregar la especialidad");
        }
    }

    // * Función para eliminar un Salón
    public function deleteEspecialidad($id)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // ? Buscamos el edificio
            $especialidades = Especialidad::findOrFail($id);
            // ? Se elimina
            $especialidades->delete();

            return back()->with("Correcto", "Se ha eliminado la especialidad correctamente");
        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al eliminar la especialidad");
        }
    }

    // * Función para actualizar los datos de un Salón
    public function updateEspecialidad(Request $request, $id)
    {
        //$data = $request->all();
        //return $request;
        try{
            $especialidades = Especialidad::findOrFail($id);
            $especialidades->clave_especialidad = $request->txtClaveEsp;
            $especialidades->especialidad = $request->txtEspecialidad;
            $especialidades->plan_estudio_id = $request->txtPlanEstudio;

            $especialidades->save();
            return back()->with("Correcto", "Especialidad Modificada Correctamente");
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                return back()->with('Incorrecto', 'Error al modificar, Esa clave de la especialidad ya existe');
            }
            return back()->with('Incorrecto', 'Error al modificar');
        }
    }
}
