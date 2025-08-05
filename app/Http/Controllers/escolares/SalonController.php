<?php

namespace App\Http\Controllers\escolares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salon;
use Illuminate\Database\QueryException;

class SalonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // * Función para crear un nuevo Salón
    public function createSalon(Request $request)
    {
        try {
            $request->validate([
                'txtNombreSalon' => 'required',
                'txtEdificio' => 'required',
                // Agrega más reglas de validación para otros campos aquí
                // los 'txt' vienen de la vista
            ]);
            
            // ? Crea un salón
            $salones = new Salon();
            $salones->nombre_salon = $request->txtNombreSalon;
            $salones->edificio_id = $request->txtEdificio;

            $salones->save(); //Guardamos
            
            return back()->with("Correcto", "Salón agregado correctamente");
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with("Incorrecto", "ERROR - Ese nombre del salón ya existe");
            }
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al agregar el salón");
        }
    }

    // * Función para eliminar un Salón
    public function deleteSalon($id)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // ? Buscamos el edificio
            $salones = Salon::findOrFail($id);
            // ? Se elimina
            $salones->delete();

            return back()->with("Correcto", "Se ha eliminado el salón correctamente");
        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al eliminar el salón");
        }
    }

    // * Función para actualizar los datos de un Salón
    public function updateSalon(Request $request, $id)
    {
        //$data = $request->all();
        //return $request;
        try{
            $salones = Salon::findOrFail($id);
            $salones->nombre_salon = $request->txtNombreSalon;
            $salones->edificio_id = $request->txtEdificio;

            $salones->save();
            return back()->with("Correcto", "Salón Modificado Correctamente");
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                return back()->with('Incorrecto', 'Error al modificar, el nombre del salón ya existe');
            }
            return back()->with('Incorrecto', 'Error al modificar');
        }
    }

}
