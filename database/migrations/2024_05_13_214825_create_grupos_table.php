<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_id');

            $table->foreign('periodo_id')
                ->references('id')->on('periodos');

            $table->unsignedBigInteger('plan_estudio_id');

            $table->foreign('plan_estudio_id')
                ->references('id')->on('planes_estudio');

            $table->unsignedBigInteger('materia_id');

            $table->foreign('materia_id')
                ->references('id')->on('materias');

            $table->tinyInteger('semestre');
            $table->char('letra_grupo',3);
            $table->tinyInteger('capacidad');

            $table->unsignedBigInteger('docente_id');

            $table->foreign('docente_id')
                ->references('id')->on('docentes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
