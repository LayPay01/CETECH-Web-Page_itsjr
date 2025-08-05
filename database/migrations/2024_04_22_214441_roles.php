<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $role1 = Role::create(['name' => 'escolares']);
        $role2 = Role::create(['name' => 'division']);
        $role3 = Role::create(['name' => 'docente']);
        $role4 = Role::create(['name' => 'alumno']);

        $escolares = User::create([
            'name' => 'Departamento de Escolares',
            'email' => 'escolares@sjuanrio.tecnm.mx',
            'password' => Hash::make('12345678'),
        ]);
        $escolares->assignRole($role1);
    
        $division = User::create([
            'name' => 'Departamento de División de Estudios',
            'email' => 'div_estudios@sjuanrio.tecnm.mx',
            'password' => Hash::make('12345678'),
        ]);
        $division->assignRole($role2);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
