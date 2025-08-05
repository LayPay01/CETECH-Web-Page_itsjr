<?php

namespace App\Http\Controllers\escolares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

use App\Models\Docente;
use App\Models\User;

class DocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // * Obtiene toda la lista de Docentes
    public function getDocentes()
    {
        // return view('escolares.docente');

        $docentes = Docente::all();
        return view('escolares.docente', compact('docentes'));
    }

    // * Función para crear un nuevo Docente
    public function createDocente(Request $request)
    {
        try {
            $request->validate([
                'txtRFC' => 'required|string',
                'txtNombre' => 'required|string',
                'txtAp_paterno' => 'required|string',
                'txtAp_materno' => 'required|string',
                'txtCurp' => 'required|string',
                'txtEmail' => 'required|email',
                // Agrega más reglas de validación para otros campos aquí
                // los 'txt' vienen de la vista
            ]);

            $fecha_nacimiento = substr($request->txtCurp, 4, 6);

            $user = User::create([
                'name' => $request -> txtNombre.' '.$request -> txtAp_paterno.' '.$request -> txtAp_materno,
                'email' => $request -> txtEmail,
                'password' => Hash::make('Tecsj+'.$fecha_nacimiento), 
            ]);

            $user->assignRole('docente');
                        
            // ? Crea un nuevo docente
            $docente = new Docente();
            $docente->rfc = $request->txtRFC;
            $docente->nombre = $request->txtNombre;
            $docente->ap_paterno = $request->txtAp_paterno;
            $docente->ap_materno = $request->txtAp_materno;
            $docente->curp = $request->txtCurp;
            $docente->email = $request->txtEmail;
            $docente->user_id = $user->id;

            $docente->save(); //Guardamos

            return back()->with("Correcto", "Docente agregado correctamente");
        
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with("Incorrecto", "ERROR - EL RFC del docente ya existe");
            }
            // ! Cualquier Otro error
            return back()->with("Incorrecto", "Error al dar de alta al Docente");
        }
    }

    // * Función para eliminar un Docente
    public function deleteDocente($id)
    {
    // ? Hay que recibir como parametro el id del registro a eliminar
        try {
            // ? Buscamos el docente
            $docente = Docente::findOrFail($id);
            // ? Se elimina
            $docente->delete();

            return back()->with("Correcto", "Se ha dado de baja al docente correctamente");
        } catch (QueryException $e) {
            // ! Cualquier  error
            return back()->with("Incorrecto", "Error al dar de baja al Docente");
        }
    }

    // * Función para actualizar los datos de un Docente
    public function updateDocente(Request $request, $id)
    {
        //$data = $request->all();
        //return $request;
        try{
            $docente = Docente::findOrFail($id);
            $docente->rfc = $request->txtRFC;
            $docente->nombre = $request->txtNombre;
            $docente->ap_paterno = $request->txtAp_paterno;
            $docente->ap_materno = $request->txtAp_materno;
            $docente->curp = $request->txtCurp;
            $docente->email = $request->txtEmail;

            $docente->save();
            return back()->with("Correcto", "Datos del Docente Modificados Correctamente");
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                return back()->with('Incorrecto', 'Error al modificar, el RFC del docente ya existe');
            }
            return back()->with('Incorrecto', 'Error al modificar');
        }
    }
}
