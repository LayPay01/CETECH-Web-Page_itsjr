<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estatuses', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_estatus',30);
        });

        DB::table('estatuses')->insert([
            ['nombre_estatus' => 'Baja definitiva'],
            ['nombre_estatus' => 'Baja temporal'],
            ['nombre_estatus' => 'Egresado'],
            ['nombre_estatus' => 'Inscrito'],
            ['nombre_estatus' => 'Reinscrito'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('estatuses');
    }
};
