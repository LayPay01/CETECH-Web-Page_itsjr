<?php

namespace App\Http\Controllers\escolares;

use App\Http\Controllers\Controller;
use App\Models\Materia;
use App\Models\MateriaPlanEstudio;
use App\Models\PlanEstudio;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MateriaPlanEstudioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // * Obtiene toda la lista de Materias asignadas a un plan de estudio
    public function getMateriasPlanes($id)
    {
        // Encuentra el plan de estudio por su id
        $planes = PlanEstudio::find($id);

        // Obtiene los ids de las materias ya asignadas a este plan de estudio
        $materiasAsignadasIds = $planes->materias()->pluck('materias.id');

        // Obtiene todas las materias que no están ya asignadas a este plan de estudio
        $materias = Materia::whereNotIn('id', $materiasAsignadasIds)->get();

        return view('division.materias_planes', compact('materias','planes'));
    }

    // * Función para crear una relación Materia - Plan
    public function createMateriaPlan(Request $request, $idPlan)
    {
        try {
            $request->validate([
                'txtMateria' => 'required',
            ]);

            $planEstudio = PlanEstudio::find($idPlan);

            // Verifica si la relación ya existe
            if ($planEstudio->materias()->where('materia_id', $request->txtMateria)->exists()) {
                return back()->with("Incorrecto", "ERROR - Esa materia ya está asignada");
            }
    
            // Si la materia no existe, la agrega
            $planEstudio->materias()->attach($request->txtMateria);
            
            return back()->with("Correcto", "Materia agregada correctamente");
        
        } catch (QueryException $e) {
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al agregar la materia");
        }
    }

    // * Función para eliminar un Plan de Estudio
    public function deleteMateriaPlan($idPlan, $idMateria)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // Buscamos el plan de estudio
            $planEstudio = PlanEstudio::find($idPlan);

            // Verificamos si la relación existe
            if ($planEstudio->materias()->where('materia_id', $idMateria)->exists()) {
                // Si existe, la eliminamos
                $planEstudio->materias()->detach($idMateria);

                return back()->with("Correcto", "Se ha eliminado la materia");
            } else {
                return back()->with("Incorrecto", "La materia no existe");
            }

        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al eliminar la materia");
        }
    }
}
