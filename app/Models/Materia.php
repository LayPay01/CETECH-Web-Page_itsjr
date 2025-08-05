<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'clave_materia',
        'nombre',
        'semestre',
    ];

    // Indicar a Laravel que no maneje las marcas de tiempo
    public $timestamps = false;

    public function plan_estudio() {
        return  $this->belongsToMany(PlanEstudio::class);
    }

    public function Grupo() {
        return $this->hasMany(Grupo::class);
    }
}
