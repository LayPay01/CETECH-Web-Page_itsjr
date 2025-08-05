<?php

namespace App\Http\Controllers\escolares;

// Use
    use App\Http\Controllers\Controller;
    use App\Models\Alumno;
    use App\Models\Docente;
    use App\Models\Grupo;
    use App\Models\Materia;
    use App\Models\Periodo;
    use App\Models\PlanEstudio;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // TODO: ------------------------------------- Division - Grupos -------------------------------------

    // * Obtiene toda la lista de Grupos asignados a un plan de estudio
    public function getGrupos($idPlan)
    {
        // Encuentra el plan de estudio por su id
        $planes = PlanEstudio::find($idPlan);

        $grupos = Grupo::all();
        $periodos = Periodo::whereRaw("estatus = 'En Curso' OR estatus = 'Preparacion' ")->orderBy('clave_periodo','desc')->get();
        
        // Obtiene los ids de las materias ya asignadas a este plan de estudio
        $materiasAsignadasIds = $planes->materias()->pluck('materias.id');
        // Obtiene todas las materias que están ya asignadas a este plan de estudio
        $materias = Materia::whereIn('id', $materiasAsignadasIds)->get();
        
        $docentes = Docente::all();

        return view('division.grupos', compact('grupos','periodos','planes','materias','docentes'));
    }

    // * Obtiene los grupos que aún no han sido asignados a alguna materia
    public function getGruposDeMateria($planId, $materiaId)
    {
        $grupos = Grupo::where('plan_estudio_id', $planId)
                    ->where('materia_id', $materiaId)
                    ->pluck('letra_grupo');
        return response()->json($grupos);
    }

    // * Función para crear una relación Materia - Plan
    public function createGrupo(Request $request, $idPlan)
    {
        try {
            $request->validate([
                'txtPeriodo' => 'required',
                'txtMateria' => 'required',
                'txtSemestre' => 'required',
                'txtLetra' => 'required',
                'txtCapacidad' => 'required',
                'txtDocente' => 'required',
            ]);

            // Crea un nuevo grupo
            $grupo = new Grupo();
            $grupo->periodo_id = $request->txtPeriodo;
            $grupo->materia_id = $request->txtMateria;
            $grupo->semestre = $request->txtSemestre;
            $grupo->letra_grupo = $request->txtLetra;
            $grupo->capacidad = $request->txtCapacidad;
            $grupo->docente_id = $request->txtDocente;
            $grupo->plan_estudio_id = $idPlan;

            $grupo->save(); //Guardamos
            
            return back()->with("Correcto", "Grupo agregado correctamente");
        
        } catch (QueryException $e) {
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al agregar el grupo");
        }
    }

    // * Función para eliminar un Grupo
    public function deleteGrupo($id)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // ? Buscamos el plan de estudio
            $grupo = Grupo::findOrFail($id);
            // ? Se elimina
            $grupo->delete();

            return back()->with("Correcto", "Se ha eliminado el grupo correctamente");
        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al eliminar el grupo");
        }
    }

    // * Función para actualizar los datos generales de un Grupo
    public function updateGrupo(Request $request, $id)
    {
        //$data = $request->all();
        //return $request;
        try{
            $grupo = Grupo::findOrFail($id);
            /*$grupo->periodo_id = $request->txtPeriodo;
            $grupo->materia_id = $request->txtMateria;
            $grupo->semestre = $request->txtSemestre;
            $grupo->letra_grupo = $request->txtLetra;*/
            $grupo->capacidad = $request->txtCapacidad;
            $grupo->docente_id = $request->txtDocente;
    
            if ($grupo->isDirty()) {
                // El modelo ha sido modificado, así que guardamos los cambios
                $grupo->save();
                return back()->with("Correcto", "Grupo Modificado Correctamente");
            } else {
                // El modelo no ha sido modificado, así que no hacemos nada
                return back()->with("Info", "No se realizaron cambios");
            }
        } catch (QueryException $e) {
            return back()->with('Incorrecto', 'Error al modificar');
        }
    }

    // TODO: ------------------------------------- Division - Alumnos -------------------------------------

    // * Función para mostrar los alumnos de un Grupo (Division)
    public function getGruposAlumnos($id){
        $grupos = Grupo::find($id);

        // Obtén los IDs de los alumnos que ya están en el grupo
        $alumnosEnGrupo = $grupos->Alumno()->pluck('alumnos.id');
        // Obtén todos los alumnos que no están en ese grupo
        $alumnos = Alumno::whereNotIn('id', $alumnosEnGrupo)->get();

        return view('division.grupos_alumnos', compact('grupos', 'alumnos'));
    }

    // * Función para crear una relación Gruoi - Alumno
    public function createGrupoAlumno(Request $request, $idGrupo)
    {
        try {
            $request->validate([
                'txtAlumno' => 'required',
            ]);

            $grupo = Grupo::find($idGrupo);

            // Verifica si la relación ya existe
            if ($grupo->Alumno()->where('alumno_id', $request->txtAlumno)->exists()) {
                return back()->with("Incorrecto", "ERROR - Ese alumno ya está asignada");
            }

            // Si el alumno no está asignado, lo agrega
            $grupo->Alumno()->attach($request->txtAlumno);
            
            return back()->with("Correcto", "Alumno agregado correctamente");
        
        } catch (QueryException $e) {
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al agregar el alumno");
        }
    }

    // * Función para eliminar un Alumno de un Grupo
    public function deleteGrupoAlumno($idGrupo, $idAlumno)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // Buscamos el plan de estudio
            $grupo = Grupo::find($idGrupo);

            // Verificamos si la relación existe
            if ($grupo->Alumno()->where('alumno_id', $idAlumno)->exists()) {
                // Si existe, la eliminamos
                $grupo->Alumno()->detach($idAlumno);

                return back()->with("Correcto", "Se ha eliminado el alumno de este grupo");
            } else {
                return back()->with("Incorrecto", "El alumno no existe");
            }

        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al eliminar el alumno de este grupo");
        }
    }

    // TODO: ------------------------------------- Docente -------------------------------------

    // * Función para mostrar los Grupos del Docente
    public function getGruposDocente($id){
        $docentes = Docente::find($id);

        return view('docente.lista_grupos', compact('docentes'));
    }

    // * Función para mostrar los alumnos de un Grupo (Docente)
    public function getGruposDocenteAlumnos($id){
        $grupos = Grupo::find($id);

        return view('docente.lista_alumnos', compact('grupos'));
    }

    // TODO: ------------------------------------- Alumno -------------------------------------

    // * Función para mostrar los alumnos de un Grupo
    public function getGruposAlumno($id){
        $alumnos = Alumno::find($id);

        return view('alumno.lista_grupos', compact('alumnos'));
    }

}