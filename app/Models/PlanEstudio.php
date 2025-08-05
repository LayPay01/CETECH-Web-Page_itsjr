<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
    use HasFactory;
    
    protected $table = 'planes_estudio';

    protected $fillable = [
        'Clave_plan_estudio',
        'Carrera',
    ];

    public $timestamps = false;

    public function Especialidades() {
        return $this->hasMany(Especialidad::class);
    }

    public function Alumnos() {
        return $this->hasMany(Alumno::class);
    }

    public function Materias() {
        return  $this->belongsToMany(Materia::class);
    }

    public function Grupos() {
        return $this->hasMany(Grupo::class);
    }
}