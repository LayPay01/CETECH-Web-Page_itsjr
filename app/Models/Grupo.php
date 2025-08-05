<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'periodo_id',
        'plan_estudio_id',
        'materia_id',
        'semestre',
        'letra_grupo',
        'capacidad',
        'docente_id',
    ];

    // Indicar a Laravel que no maneje las marcas de tiempo
    public $timestamps = false;

    public function Periodo() {
        return $this->belongsTo(Periodo::class);
    }

    public function plan_estudio() {
        return $this->belongsTo(PlanEstudio::class);
    }

    public function Materia() {
        return $this->belongsTo(Materia::class);
    }

    public function Docente() {
        return $this->belongsTo(Docente::class);
    }

    public function Alumno() {
        return  $this->belongsToMany(Alumno::class);
    }
}
