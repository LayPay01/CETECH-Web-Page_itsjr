<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoGrupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'grupo_id',
    ];

    // Indicar a Laravel que no maneje las marcas de tiempo
    public $timestamps = false;

    public function Alumno() {
        return $this->belongsTo(Alumno::class);
    }

    public function Grupo() {
        return $this->belongsTo(Grupo::class);
    }
}
