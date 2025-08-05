@extends('layouts.plantilla')

@section('title', 'SIE - División - Plan-Materias')

@section('content')
    <div class="box has-shadow">
        <p class="title is-5 has-text-centered"><i class="fa-solid fa-book"></i>&nbsp;{{$planes->Carrera}}</p>
        <div>
            <p class="title is-4 has-text-centered">Materias</p>
            <hr>
        </div>

        <div class="buttons">
            <a href="{{ route('divisionPlanesEstudio') }}" class="button is-danger is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</a>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nva-materia"><i class="fa-solid fa-plus"></i>&nbsp;Nueva Materia</button>
        </div>

        @if (session('Correcto'))
            <div class="notification is-primary">
                <button class="delete"></button>
                {{session('Correcto')}}
            </div>
        @endif
        @if (session('Incorrecto'))
            <div class="notification is-danger">
                <button class="delete"></button>
                {{session('Incorrecto')}}
            </div>
        @endif

        <table class='table is-fullwidth is-striped is-narrow is-hoverable'>
            <thead>
            <tr class="th is-selected has-text-black">
                <th class="is-vcentered">Clave</th>
                <th class="is-vcentered">Nombre de la Materia</th>
                <th class="is-vcentered has-text-centered">Creditos</th>
                <th class="has-text-centered">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($planes->materias as $materia)
                    <tr>
                        <td class="is-vcentered">{{ $materia->clave_materia }}</td>
                        <td class="is-vcentered">{{ $materia->nombre }}</td>
                        <td class="is-vcentered has-text-centered">{{ $materia->creditos }}</td>
                        <td class="is-vcentered">
                            <div class="field is-grouped is-grouped-centered">                                
                                <form action="{{ route('MateriaPlanEliminar', [$planes->id, $materia->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-danger is-responsive" title="Eliminar {{ $materia->nombre }}" onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Este es el modal para crear un nuevo plan de estudio -->
    <div id="modal-nva-materia" class="modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Nueva Materia</p>
                <form method="POST" action="{{ route('MateriaPlanCrear', $planes->id) }}">
                    @csrf
                    @method('POST')

                    <div class="field">
                        <div class="control">
                            <label class="label">Materias:</label>
                            <div class="control has-icons-left">
                                <div class="is-fullwidth" >
                                    <select name='txtMateria' class="Materias">
                                        <option value="">Selecciona una Materia</option>
                                        @foreach ($materias as $materia)
                                            <option value="{{$materia->id}}">
                                                {{ $materia->clave_materia }} - {{ $materia->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-address-card"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @error('txtMateria')
                            <p class="help is-danger">Debes seleccionar una materia</p>
                        @enderror
                    </div>

                    <div class="has-text-centered">
                        <button class="button is-primary" type="submit"><i
                                class="fa-solid fa-floppy-disk"></i>&nbsp;Agregar</button>
                    </div>
                </form>
                <!-- Your content -->
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!-- Este es el modal para crear un nuevo plan de estudio (fin) -->

    @if ($errors->has('txtMateria'))
        <script>
            document.getElementById('modal-nva-materia').classList.add('is-active');
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('select.Materias').select2();
        });
    </script>
@endsection