<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\escolares\AlumnoController;
use App\Http\Controllers\escolares\PlanEstudioController;
use App\Http\Controllers\escolares\EspecialidadController;
use App\Http\Controllers\escolares\DocenteController;
use App\Http\Controllers\escolares\EdificioController;
use App\Http\Controllers\escolares\GrupoController;
use App\Http\Controllers\escolares\MateriaController;
use App\Http\Controllers\escolares\MateriaPlanEstudioController;
use App\Http\Controllers\escolares\PeriodoController;
use App\Http\Controllers\escolares\SalonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

/* Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/login', function () {
    return view('login');
});*/
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/changePassword', [HomeController::class, 'changePassword'])->name('changePassword');

// TODO: ------------------------------------ Rol - escolares ------------------------------------ //
Route::group(['middleware' => ['role:escolares']], function () {

    // ? ------------------------------------ Alumnos ------------------------------------ //

    Route::get('/escolares/alumnos', [AlumnoController::class, 'getAlumnos'])->name('escolaresAlumnos');
    Route::post('/escolares/alumnos/create', [AlumnoController::class, 'createALumno'])->name('AlumnoCrear');
    Route::delete('/escolares/alumnos/delete/{id}', [AlumnoController::class, 'deleteALumno'])->name('AlumnoEliminar');
    Route::patch('/escolares/alumnos/update/{id}', [AlumnoController::class, 'updateALumno'])->name('AlumnoUpdate');

    // ? ------------------------------------ Periodos ------------------------------------ //

    Route::get('/escolares/periodos', [PeriodoController::class, 'getPeriodos'])->name('escolaresPeriodos');
    Route::post('/escolares/periodo/create', [PeriodoController::class, 'createPeriodo'])->name('PeriodoCrear');
    Route::delete('/escolares/periodo/delete/{id}', [PeriodoController::class, 'deletePeriodo'])->name('PeriodoEliminar');
    Route::patch('/escolares/periodo/update/{id}', [PeriodoController::class, 'updatePeriodo'])->name('PeriodoUpdate');
    // ! Nueva ruta para obtener los estatus de los periodos existentes
    Route::get('/escolares/periodos/estatus', [PeriodoController::class, 'getEstatusDePeriodos'])->name('estatusPeriodos');

    // ? ------------------------------------ Docentes ------------------------------------ //

    Route::get('/escolares/docentes', [DocenteController::class, 'getDocentes'])->name('escolaresDocentes');
    Route::post('/escolares/docente/create', [DocenteController::class, 'createDocente'])->name('DocentesCrear');
    Route::delete('/escolares/docente/delete/{id}', [DocenteController::class, 'deleteDocente'])->name('DocenteEliminar');
    Route::patch('/escolares/docente/update/{id}', [DocenteController::class, 'updateDocente'])->name('DocenteUpdate');

    // ? ------------------------------------ Edificios ------------------------------------ //

    Route::get('/escolares/edificios', [EdificioController::class, 'getEdificios'])->name('escolaresEdificios');
    Route::post('/escolares/edificios/create', [EdificioController::class, 'createEdificio'])->name('EdificioCrear');
    Route::delete('/escolares/edificios/delete/{id}', [EdificioController::class, 'deleteEdificio'])->name('EdificioEliminar');
    Route::patch('/escolares/edificios/update/{id}', [EdificioController::class, 'updateEdificio'])->name('EdificioUpdate');

    // * ------------------------------------ Salones ------------------------------------ //

    Route::post('/escolares/salones/create', [SalonController::class, 'createSalon'])->name('SalonCrear');
    Route::delete('/escolares/salones/delete/{id}', [SalonController::class, 'deleteSalon'])->name('SalonEliminar');
    Route::patch('/escolares/salones/update/{id}', [SalonController::class, 'updateSalon'])->name('SalonUpdate');
});

// TODO: ------------------------------------ Rol - division ------------------------------------ //
Route::group(['middleware' => ['role:division']], function () {

    // ? ------------------------------------ Planes de Estudio ------------------------------------ //

    Route::get('/division/planes_estudio', [PlanEstudioController::class, 'getPlanes'])->name('divisionPlanesEstudio');
    Route::post('/division/plan-estudio/create', [PlanEstudioController::class, 'createPlanEstudio'])->name('PlanesEstudioCrear');
    Route::delete('/division/plan-estudio/delete/{id}', [PlanEstudioController::class, 'deletePlanEstudio'])->name('PlanesEstudioEliminar');
    Route::patch('/division/plan-estudio/update/{id}', [PlanEstudioController::class, 'updatePlanEstudio'])->name('PlanesEstudioUpdate');

    // * ------------------------------------ Especialidades ------------------------------------ //

    Route::post('/division/especialidades/create', [EspecialidadController::class, 'createEspecialidad'])->name('EspecialidadCrear');
    Route::delete('/division/especialidades/delete/{id}', [EspecialidadController::class, 'deleteEspecialidad'])->name('EspecialidadEliminar');
    Route::patch('/division/especialidades/update/{id}', [EspecialidadController::class, 'updateEspecialidad'])->name('EspecialidadUpdate');

    // * ------------------------------------ Materias ------------------------------------ //

    Route::get('/division/materias', [MateriaController::class, 'getMaterias'])->name('divisionMaterias');
    Route::post('/division/materia/create', [MateriaController::class, 'createMateria'])->name('MateriaCrear');
    Route::delete('/division/materia/delete/{id}', [MateriaController::class, 'deleteMateria'])->name('MateriaEliminar');
    Route::patch('/division/materia/update/{id}', [MateriaController::class, 'updateMateria'])->name('MateriaUpdate');

    // * ------------------------------------ Materias - Planes de Estudio ------------------------------------ //

    Route::get('/division/materias_plan/{id}', [MateriaPlanEstudioController::class, 'getMateriasPlanes'])->name('divisionMateriasPlanes');
    Route::post('/division/materia_plan/create/{idPlan}', [MateriaPlanEstudioController::class, 'createMateriaPlan'])->name('MateriaPlanCrear');
    Route::delete('/division/materia_plan/delete/{idPlan}/{idMateria}', [MateriaPlanEstudioController::class, 'deleteMateriaPlan'])->name('MateriaPlanEliminar');

    // * ------------------------------------ Grupos ------------------------------------ //

    Route::get('/division/grupos/{idPlan}', [GrupoController::class, 'getGrupos'])->name('divisionGrupos');
    Route::post('/division/grupos/create/{idPlan}', [GrupoController::class, 'createGrupo'])->name('GrupoCrear');
    Route::delete('/division/grupos/delete/{id}', [GrupoController::class, 'deleteGrupo'])->name('GrupoEliminar');
    Route::patch('/division/grupos/update/{id}', [GrupoController::class, 'updateGrupo'])->name('GrupoUpdate');
    // ! Obtiene la Letra Grupo que no esté asignada a una materia
    Route::get('/plan/{planId}/materia/{materiaId}/grupos', [GrupoController::class, 'getGruposDeMateria'])->name('materiaGrupos');

    // * ------------------------------------ Grupos - Alumnos ------------------------------------ //
    Route::get('/division/grupo_alumno/{id}', [GrupoController::class, 'getGruposAlumnos'])->name('divisionAlumnosGrupos');
    Route::post('/division/grupo_alumno/create/{idGrupo}', [GrupoController::class, 'createGrupoAlumno'])->name('AlumnoGrupoCrear');
    Route::delete('/division/grupo_alumno/delete/{idGrupo}/{idAlumno}', [GrupoController::class, 'deleteGrupoAlumno'])->name('AlumnoGrupoEliminar');
});

// TODO: ------------------------------------ Rol - docente ------------------------------------ //
Route::group(['middleware' => ['role:docente']], function () {
    // ? ------------------------------------ Lista de Grupos ------------------------------------ //
    Route::get('/docente/grupos/{id}', [GrupoController::class, 'getGruposDocente'])->name('docenteGrupos');
    Route::get('/docente/grupos/alumnos/{id}', [GrupoController::class, 'getGruposDocenteAlumnos'])->name('docenteAlumnosGrupos');
});

// TODO: ------------------------------------ Rol - alumno ------------------------------------ //
Route::group(['middleware' => ['role:alumno']], function () {
    // ? ------------------------------------ Lista de Grupos ------------------------------------ //
    Route::get('/alumno/grupos/{id}', [GrupoController::class, 'getGruposAlumno'])->name('alumnoGrupos');
});