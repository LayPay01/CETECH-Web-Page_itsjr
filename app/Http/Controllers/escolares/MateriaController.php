<?php

namespace App\Http\Controllers\escolares;

use App\Http\Controllers\Controller;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MateriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // * Obtiene toda la lista de Planes de Estudio
    public function getMaterias()
    {
        /*foreach (PlanEstudio::all() as $flight) {
            echo $flight->name;
        }*/
        /*
        $test = "Hola Mundo";
        $name = "Leo";
        */
        //return view('escolares.PlanesEstudio', ['perro' => $test]);
        $materias = Materia::all();
        return view('division.materias', compact('materias'));
    }

    // * Función para crear un nuevo Plan de Estudio
    public function createMateria(Request $request)
    {
        try {
            $request->validate([
                'txtClave' => 'required|string|regex:/^[A-Z]{3}-\d{4}$/',
                'txtNombre' => 'required|string',
                'txtCreditos' => 'required',
                // Agrega más reglas de validación para otros campos aquí
                // los 'txt' vienen de la vista
            ]);

            // ? Crea un nuevo plan
            $materia = new Materia();
            $materia->clave_materia = $request->txtClave;
            $materia->nombre = $request->txtNombre;
            $materia->creditos = $request->txtCreditos;

            $materia->save(); //Guardamos
            
            return back()->with("Correcto", "Materia agregada correctamente");
        
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with("Incorrecto", "ERROR - Esa clave de la materia ya existe");
            }
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al agregar la materia");
        }
    }

    // * Función para eliminar un Plan de Estudio
    public function deleteMateria($id)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // ? Buscamos el plan de estudio
            $materia = Materia::findOrFail($id);
            // ? Se elimina
            $materia->delete();

            return back()->with("Correcto", "Se ha eliminado la materia correctamente");
        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al eliminar la materia");
        }
    }

    // * Función para actualizar los datos de un Plan de Estudio
    public function updateMateria(Request $request, $id)
    {
        $request->validate([
            'txtClave1' => 'required|string|regex:/^[A-Z]{3}-\d{4}$/',
        ]);
        try{
            $materia = Materia::findOrFail($id);
            $materia->clave_materia = $request->txtClave1;
            $materia->nombre = $request->txtNombre;
            $materia->creditos = $request->txtCreditos;
    
            if ($materia->isDirty()) {
                // El modelo ha sido modificado, así que guardamos los cambios
                $materia->save();
                return back()->with("Correcto", "Materia Modificada Correctamente");
            } else {
                // El modelo no ha sido modificado, así que no hacemos nada
                return back()->with("Info", "No se realizaron cambios");
            }
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                return back()->with('Incorrecto', 'Error al modificar, la clave de la materia ya existe');
            }
            return back()->with('Incorrecto', 'Error al modificar');
        }
    }
}
