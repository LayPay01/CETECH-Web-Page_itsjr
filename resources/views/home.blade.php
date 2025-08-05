@extends('layouts.plantilla')

@section('content')
    <div class="container has-shadow has-background-white">
        <div class="column mb-2 has-background-light">
            <p class="title is-5 ml-2">Menú General</p>
        </div>
        
        <div class="columns is-multiline is-mobile m-1">
            <!-- ESCOLARES -->
            @include('home.escolares')
            <!-- ESCOLARES -->

            <!-- DOCENTES -->
            @include('home.docente')
            <!-- DOCENTES -->
            
            <!-- ALUMNOS -->
            @include('home.alumno')
            <!-- ALUMNOS -->
            
            <!-- DIVISIÓN DE ESTUDIOS -->
            @include('home.division')
            <!-- DIVISIÓN DE ESTUDIOS -->

        </div>
    </div>
@endsection
