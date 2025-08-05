<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipos_alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tipo',30);
        });

        DB::table('tipos_alumnos')->insert([
            ['nombre_tipo' => 'Cambio de carrera'],
            ['nombre_tipo' => 'Convalidación'],
            ['nombre_tipo' => 'Equivalencia'],
            ['nombre_tipo' => 'Equivalencia/ReIngreso'],
            ['nombre_tipo' => 'Movilidad'],
            ['nombre_tipo' => 'Nuevo Ingreso'],
            ['nombre_tipo' => 'Re-Ingreso'],
            ['nombre_tipo' => 'Revalidación'],
            ['nombre_tipo' => 'Traslado'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_alumnos');
    }
};
