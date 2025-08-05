<?php

namespace App\Http\Controllers\escolares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

use App\Models\Alumno;
use App\Models\Estatus;
use App\Models\PlanEstudio;
use App\Models\TipoAlumno;
use App\Models\User;

class AlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // * Obtiene toda la lista de Alumnos
    public function getAlumnos()
    {
        $alumnos = Alumno::all();
        $planes = PlanEstudio::all();
        $estatuses = Estatus::all();
        $tipos = TipoAlumno::all();
        return view('escolares.alumno', compact('alumnos', 'planes', 'estatuses', 'tipos'));
    }

    // * Función para crear un nuevo Alumno
    public function createALumno(Request $request)
    {
        try {
            $request->validate([
                'txtNC' => 'required|string',
                'txtNombre' => 'required|string',
                'txtAp_paterno' => 'required|string',
                'txtAp_materno' => 'required|string',
                'txtCurp' => 'required|string',
                'txtPlanEstudio' => 'required',
                'txtSemestre' => 'required',
                'txtEstatus' => 'required',
                'txtTipo' => 'required',
                // Agrega más reglas de validación para otros campos aquí
                // los 'txt' vienen de la vista
            ]);

            $fecha_nacimiento = substr($request->txtCurp, 4, 6);

            $user = User::create([
                'name' => $request->txtNombre . ' ' . $request->txtAp_paterno . ' ' . $request->txtAp_materno,
                'email' => 'l' . $request->txtNC . '@sjuanrio.tecnm.mx',
                'password' => Hash::make('Tecsj+' . $fecha_nacimiento),
            ]);

            $user->assignRole('alumno');

            // ? Crea un nuevo docente
            $alumno = new Alumno();
            $alumno->numero_de_control = $request->txtNC;
            $alumno->nombre = $request->txtNombre;
            $alumno->ap_paterno = $request->txtAp_paterno;
            $alumno->ap_materno = $request->txtAp_materno;
            $alumno->curp = $request->txtCurp;
            $alumno->plan_estudio_id = $request->txtPlanEstudio;
            $alumno->semestre = $request->txtSemestre;
            $alumno->estatus_id = $request->txtEstatus;
            $alumno->tipo_alumno_id = $request->txtTipo;
            $alumno->user_id = $user->id;

            $alumno->save(); //Guardamos

            return back()->with("Correcto", "Alumno agregado correctamente");
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with("Incorrecto", "ERROR - EL NC del alumno ya existe");
            }
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al dar de alta al Alumno");
        }
    }

    // * Función para eliminar un Docente
    public function deleteALumno($id)
    {
        // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // ? Buscamos el docente
            $alumno = Alumno::findOrFail($id);
            // ? Se elimina
            $alumno->delete();

            return back()->with("Correcto", "Se ha dado de baja al alumno correctamente");
        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al dar de baja al alumno");
        }
    }

    // * Función para actualizar los datos de un Docente
    public function updateALumno(Request $request, $id)
    {
        //$data = $request->all();
        //return $request;
        try {
            $alumno = Alumno::findOrFail($id);;
            //$alumno->numero_de_control = $request->txtNC;
            $alumno->nombre = $request->txtNombre;
            $alumno->ap_paterno = $request->txtAp_paterno;
            $alumno->ap_materno = $request->txtAp_materno;
            $alumno->curp = $request->txtCurp;
            $alumno->plan_estudio_id = $request->txtPlanEstudio;
            $alumno->semestre = $request->txtSemestre;
            $alumno->estatus_id = $request->txtEstatus;
            $alumno->tipo_alumno_id = $request->txtTipo;

            $alumno->save();
            return back()->with("Correcto", "Datos del Alumno Modificados Correctamente");
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('Incorrecto', 'Error al modificar, el NC del alumno ya existe');
            }
            return back()->with('Incorrecto', 'Error al modificar');
        }
    }
}
