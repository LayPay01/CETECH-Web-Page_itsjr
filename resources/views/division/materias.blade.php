@extends('layouts.plantilla')

@section('title', 'SIE - División - Materias')

@section('content')
    <div class="box has-shadow">
        <p class="title is-6 has-text-centered"><i class="fa-solid fa-book"></i>&nbsp;Materias</p>
        <div>
            <p class="title is-4 has-text-centered">Gestión de Materias</p>
            <hr>
        </div>

        <div class="buttons">
            <a href="{{ route('home') }}" class="button is-danger is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</a>
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
        @if (session('Info'))
            <div class="notification is-warning">
                <button class="delete"></button>
                {{session('Info')}}
            </div>
        @endif

        <table id="Mat" class='table is-fullwidth is-striped is-narrow is-hoverable'>
            <thead>
            <tr class="th is-selected has-text-black">
                <th class="is-vcentered ">Clave</th>
                <th class="is-vcentered ">Nombre</th>
                <th class="is-vcentered has-text-centered">Creditos</th>
                <th class="has-text-centered">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($materias as $materia)
                    <tr>
                        <td class="is-vcentered">{{ $materia->clave_materia }}</td>
                        <td class="is-vcentered">{{ $materia->nombre }}</td>
                        <td class="is-vcentered has-text-centered">{{ $materia->creditos }}</td>
                        <td class="is-vcentered">
                            <div class="field is-grouped is-grouped-centered">
                                <button class="button is-warning is-responsive js-modal-trigger mr-2" title="Editar" data-target="modal-{{ $materia->id }}">  <i class="fa-solid fa-pen-to-square"></i>   </button>
                                
                                <form action="{{ route('MateriaEliminar', $materia->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-danger is-responsive" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <!-- Modal para editar los datos generales del Docente -->
                        <div id="modal-{{ $materia->id }}" class="modal">
                            <div class="modal-background"></div>
                        
                            <div class="modal-content">
                            <div class="box">
                                <p class="title is-5 has-text-centered">Modificar Datos Generales de la Materia</p>

                                <form method="POST" action="{{route('MateriaUpdate', $materia->id)}}">
                                    @csrf
                                    @method('PATCH')

                                <div class="field">
                                    <label class="label">Clave de la Materia:</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtClave1" value="{{ $materia->clave_materia }}" >
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-key"></i>
                                        </span>
                                        @error('txtClave1')
                                            <p class="help is-danger">Formato Incorrecto (CCC-0000) | Ingresa la clave de la materia</p>
                                        @enderror
                                    </div>

                                    <label class="label">Nombre de la Materia:</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtNombre" value="{{ $materia->nombre }}">
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-font"></i>
                                        </span>
                                    </div>

                                    <label class="label">Creditos:</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="number" min="1" max="7" name="txtCreditos" value="{{ $materia->creditos }}">
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-0"></i>
                                        </span>
                                    </div>

                                </div>
                                <div class="has-text-centered">
                                    <button class="button is-primary" type="submit" onclick="return confirm('¿Estás seguro de querer actualizar este registro?')">Actualizar</button>
                                </div>
                                </form>
                            </div>
                            </div>
                        
                            <button class="modal-close is-large" aria-label="close"></button>
                        </div>
                        <!-- Modal para editar los datos generales del Docente (fin) -->
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
                <form method="POST" action="{{ route('MateriaCrear') }}">
                    @csrf
                    @method('POST')
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Clave de la Materia:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtClave" value="{{ old('txtClave') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtClave')
                            <p class="help is-danger">Formato Incorrecto (CCC-0000) | Ingresa la clave de la materia</p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Nombre de la materia:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtNombre"
                                    value="{{ old('txtNombre') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-font"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtNombre')
                            <p class="help is-danger">Ingresa el nombre de la materia</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Creditos:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="number" min="1" max="7" name = "txtCreditos"
                                    value="{{ old('txtSemestre') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-0"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtSemestre')
                            <p class="help is-danger">Ingresa la cantidad de creditos</p>
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

    @if ($errors->has('txtClave') || $errors->has('txtNombre') || $errors->has('txtCreditos'))
        <script>
            document.getElementById('modal-nva-materia').classList.add('is-active');
        </script>
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#Mat').DataTable({
                columnDefs : [
                    { orderable: false, searchable: false, target: [3] },
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