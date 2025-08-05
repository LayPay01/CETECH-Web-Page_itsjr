<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    public $timestamps = false;

    public function user() {
        return  $this->belongsTo(User::class);
    }

    public function Grupo() {
        return $this->hasMany(Grupo::class);
    }
}
