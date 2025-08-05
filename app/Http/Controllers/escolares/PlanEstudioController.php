<?php

namespace App\Http\Controllers\escolares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanEstudio;
use App\Models\Especialidad;
use App\Models\User;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Auth;

class PlanEstudioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // * Obtiene toda la lista de Planes de Estudio
    public function getPlanes()
    {
        /*foreach (PlanEstudio::all() as $flight) {
            echo $flight->name;
        }*/
        /*
        $test = "Hola Mundo";
        $name = "Leo";
        */
        //return view('escolares.PlanesEstudio', ['perro' => $test]);
        $planes = PlanEstudio::all();
        $especialidades = Especialidad::all();
        
        // ! $user = Auth::user();
        // * Esto en la vista para decir si un usuario puede ver o no cierta acción
        // ! {{ $user->hasRole('division') ? 'is-hidden' : '' }}
        return view('division.PlanesEstudio', compact('planes', 'especialidades'));
    }

    // * Función para crear un nuevo Plan de Estudio
    public function createPlanEstudio(Request $request)
    {
        try {
            $request->validate([
                'txtClave' => 'required|string',
                'txtCarrera' => 'required|string',
                // Agrega más reglas de validación para otros campos aquí
                // los 'txt' vienen de la vista
            ]);

            // ? Crea un nuevo plan
            $plan = new PlanEstudio();
            $plan->clave_plan_estudio = $request->txtClave;
            $plan->carrera = $request->txtCarrera;

            $plan->save(); //Guardamos
            
            return back()->with("Correcto", "Plan de estudio agregado correctamente");
        
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with("Incorrecto", "ERROR - Esa clave de plan de estudios ya existe");
            }
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al agregar el plan de estudios");
        }
    }

    // * Función para eliminar un Plan de Estudio
    public function deletePlanEstudio($id)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // ? Buscamos el plan de estudio
            $planEstudio = PlanEstudio::findOrFail($id);
            // ? Se elimina
            $planEstudio->delete();

            return back()->with("Correcto", "Se ha eliminado el plan de estudio correctamente");
        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al agregar el plan de estudios");
        }
    }

    // * Función para actualizar los datos de un Plan de Estudio
    public function updatePlanEstudio(Request $request, $id)
    {
        //$data = $request->all();
        //return $request;
        try{
            $plan = PlanEstudio::findOrFail($id);
            $plan->Clave_plan_estudio = $request->txtClave1;
            $plan->carrera = $request->txtCarrera;
    
            if ($plan->isDirty()) {
                // El modelo ha sido modificado, así que guardamos los cambios
                $plan->save();
                return back()->with("Correcto", "Grupo Modificado Correctamente");
            } else {
                // El modelo no ha sido modificado, así que no hacemos nada
                return back()->with("Info", "No se realizaron cambios");
            }
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                return back()->with('Incorrecto', 'Error al modificar, la clave del plan ya existe');
            }
            return back()->with('Incorrecto', 'Error al modificar, la clave del plan ya existe');
        }
    }
}
