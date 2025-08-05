<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_de_control',15)->unique();
            $table->string('nombre');
            $table->string('ap_paterno');
            $table->string('ap_materno');
            $table->string('curp',18)->unique();
            
            $table->unsignedBigInteger('plan_estudio_id');
            $table->foreign('plan_estudio_id')
            ->references('id')->on('planes_estudio');
            
            $table->integer('semestre');

            $table->unsignedBigInteger('estatus_id');
            $table->foreign('estatus_id')
            ->references('id')->on('estatuses');
            
            $table->unsignedBigInteger('tipo_alumno_id');
            $table->foreign('tipo_alumno_id')
                ->references('id')->on('tipos_alumnos');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
