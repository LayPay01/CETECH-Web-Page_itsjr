@extends('layouts.plantilla')

@section('title', 'SIE - División - Grupos-Alumnos')

@section('content')
<style>
    #Alumns td:first-child {
        text-align: left;
    }
    #Alumns th:first-child {
        text-align: left;
    }
</style>
    <div class="box has-shadow">
        <p class="title is-5 has-text-centered"><i class="fa-solid fa-book"></i>
            &nbsp;{{$grupos->materia->nombre}} - Gpo: {{$grupos->letra_grupo}} - {{$grupos->Docente->nombre}} {{$grupos->Docente->ap_paterno}} {{$grupos->Docente->ap_materno}}</p>
        <div>
            <p class="title is-4 has-text-centered">Gestión de Alumnos</p>
            <hr>
        </div>

        <div class="buttons">
            <button onclick="goBack()" class="button is-danger back is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</button>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nvo-alumno"><i class="fa-solid fa-plus"></i>&nbsp;Nuevo Alumno</button>
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
        @if (session('Info'))
            <div class="notification is-warning">
                <button class="delete"></button>
                {{session('Info')}}
            </div>
        @endif

        <table id="Alumns" class='table is-fullwidth is-striped is-narrow is-hoverable'>
            <thead>
            <tr class="th is-selected has-text-black">
                <th class="is-vcentered">No. Control</th>
                <th class="is-vcentered">Apellidos</th>
                <th class="is-vcentered">Nombres</th>
                <th class="is-vcentered has-text-centered">Semestre</th>
                <th class="has-text-centered">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($grupos->Alumno as $alumno)
                    <tr>
                        <td class="is-vcentered">{{ $alumno->numero_de_control }}</td>
                        <td class="is-vcentered">{{ $alumno->ap_paterno }} {{ $alumno->ap_materno }}</td>
                        <td class="is-vcentered">{{ $alumno->nombre }}</td>
                        <td class="is-vcentered has-text-centered">{{ $alumno->semestre }}</td>
                        <td class="is-vcentered">
                            <div class="field is-grouped is-grouped-centered">                                
                                <form action="{{ route('AlumnoGrupoEliminar', [$grupos->id, $alumno->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-danger is-responsive" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
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

    <!-- Este es el modal para agregar un alumno al grupo -->
    <div id="modal-nvo-alumno" class="modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Nuevo Alumno</p>
                <form method="POST" action="{{ route('AlumnoGrupoCrear', $grupos->id) }}">
                    @csrf
                    @method('POST')

                    <div class="field">
                        <div class="control">
                            <label class="label">Alumnos:</label>
                            <div class="control has-icons-left">
                                <div class="is-fullwidth" >
                                    <select name='txtAlumno' class="Alumnos">
                                        <option value="">Selecciona un Alumno</option>
                                        @foreach ($alumnos as $alumno)
                                            <option value="{{$alumno->id}}">
                                                {{ $alumno->numero_de_control }} - {{ $alumno->ap_paterno }} {{ $alumno->ap_materno }} {{ $alumno->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-address-card"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @error('txtAlumno')
                            <p class="help is-danger">Debes seleccionar un alumno</p>
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
    <!-- Este es el modal para agregar un alumno al grupo (fin) -->

    @if ($errors->has('txtAlumno'))
        <script>
            document.getElementById('modal-nvo-alumno').classList.add('is-active');
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('select.Alumnos').select2();
            var table = $('#Alumns').DataTable({
                columnDefs : [
                    { orderable: false, searchable: false, target: [4] },
                    { orderable: false, target: [2] },
                ],
                lengthMenu: [5, 10, 25, 50],
                language: {
                    url: '/js/es-MX.js',
                },
            });
            table.order([1, 'asc']).draw();
            
        });
    </script>
@endsection