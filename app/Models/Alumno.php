<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    public $timestamps = false;

    public function user() {
        return  $this->belongsTo(User::class);
    }

    public function tipo_alumno() {
        return  $this->belongsTo(TipoAlumno::class);
    }

    public function estatus() {
        return  $this->belongsTo(Estatus::class);
    }

    public function plan_estudio() {
        return  $this->belongsTo(PlanEstudio::class);
    }

    public function Grupo() {
        return  $this->belongsToMany(Grupo::class);
    }
}
