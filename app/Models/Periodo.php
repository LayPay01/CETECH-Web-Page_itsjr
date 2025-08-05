<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $table = 'periodos';

    protected $fillable = [
        'clave_periodo',
        'nombre_periodo',
        'estatus',
    ];

    // Indicar a Laravel que no maneje las marcas de tiempo
    public $timestamps = false;

    public function Grupo() {
        return $this->hasMany(Grupo::class);
    }
}
