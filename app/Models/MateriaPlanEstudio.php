<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaPlanEstudio extends Model
{
    use HasFactory;

    protected $table = 'materia_plan_estudios';

    protected $fillable = [
        'materia_id',
        'plan_estudio_id',
    ];

    // Indicar a Laravel que no maneje las marcas de tiempo
    public $timestamps = false;

    public function materia() {
        return $this->belongsTo(Materia::class);
    }

    public function plan_estudio() {
        return $this->belongsTo(PlanEstudio::class);
    }
}