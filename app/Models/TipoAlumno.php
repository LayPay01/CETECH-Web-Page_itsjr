<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAlumno extends Model
{
    use HasFactory;

    protected $table = 'tipos_alumnos';

    protected $fillable = [
        'nombre_tipo',
    ];

    public $timestamps = false;

    public function Alumnos() {
        return $this->hasMany(Alumno::class);
    }
}
