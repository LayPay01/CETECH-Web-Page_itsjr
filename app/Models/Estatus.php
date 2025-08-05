<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
    use HasFactory;

    protected $table = 'estatuses';

    protected $fillable = [
        'nombre_estatus',
    ];

    public $timestamps = false;

    public function Alumnos() {
        return $this->hasMany(Alumno::class);
    }
}
