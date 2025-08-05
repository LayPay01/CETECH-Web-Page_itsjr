<?php

namespace App\Http\Controllers\escolares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Edificio;
use App\Models\Salon;
use Illuminate\Database\QueryException;

class EdificioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // * Obtiene toda la lista de Edificios
    public function getEdificios()
    {
        /*foreach (PlanEstudio::all() as $flight) {
            echo $flight->name;
        }*/
        /*
        $test = "Hola Mundo";
        $name = "Leo";
        */
        //return view('escolares.PlanesEstudio', ['perro' => $test]);
        $edificios = Edificio::all();
        $salones = Salon::all();
        return view('escolares.edificio', compact('edificios','salones'));
    }

    // * Función para crear un nuevo Edificio
    public function createEdificio(Request $request)
    {
        try {
            $request->validate([
                'txtNombreEdificio' => 'required|string',
                // Agrega más reglas de validación para otros campos aquí
                // los 'txt' vienen de la vista
            ]);

            // ? Crea un edificio
            $edificios = new Edificio();
            $edificios->nombre_edificio = $request->txtNombreEdificio;
            $edificios->descripcion = $request->txtDescripcion;

            $edificios->save(); //Guardamos
            
            return back()->with("Correcto", "Edificio agregado correctamente");
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with("Incorrecto", "ERROR - Ese nombre del edificio ya existe");
            }
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al agregar el edificio");
        }
    }

    // * Función para eliminar un Edificio
    public function deleteEdificio($id)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // ? Buscamos el edificio
            $edificios = Edificio::findOrFail($id);
            // ? Se elimina
            $edificios->delete();

            return back()->with("Correcto", "Se ha eliminado el edificio correctamente");
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1451) {
                return back()->with('Incorrecto', 'Error al eliminar, este edificio ya cuenta con salones asignados');
            }
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al eliminar el edificio");
        }
    }

    // * Función para actualizar los datos de un Edificio
    public function updateEdificio(Request $request, $id)
    {
        //$data = $request->all();
        //return $request;
        try{
            $edificios = Edificio::findOrFail($id);
            $edificios->nombre_edificio = $request->txtNombreEdificio;
            $edificios->descripcion = $request->txtDescripcion;

            $edificios->save();
            return back()->with("Correcto", "Edificio Modificado Correctamente");
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                return back()->with('Incorrecto', 'Error al modificar, el nombre del edificio ya existe');
            }
            return back()->with('Incorrecto', 'Error al modificar, el nombre del edificio ya existe');
        }
    }
}
