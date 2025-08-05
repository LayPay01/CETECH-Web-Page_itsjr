@extends('layouts.plantilla')

@section('title', 'SIE - Escolares - Docentes')

@section('content')
    <div class="box has-shadow">
        <p class="title is-6 has-text-centered"><i class="fa-solid fa-chalkboard-user"></i>&nbsp;Docentes</p>
        <div>
            <p class="title is-4 has-text-centered">Gestión de Docentes</p>
            <hr>
        </div>

        <div class="buttons">
            <a href="{{ route('home') }}" class="button is-danger is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</a>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nvo-docente"><i class="fa-solid fa-plus"></i>&nbsp;Alta de Docente</button>
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

        <table id="Teachers" class='table is-fullwidth is-striped is-narrow is-hoverable'>
            <thead>
            <tr class="th is-selected has-text-black">
                <th>RFC</th>
                <th>Nombre</th>
                <th class="is-hidden-mobile">Apellido Paterno</th>
                <th class="is-hidden-mobile">Apellido Materno</th>
                <th class="is-hidden-mobile">CURP</th>
                <th class="is-hidden-mobile">Correo</th>
                <th class="has-text-centered">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($docentes as $item)
                    <tr>
                        <td class="is-vcentered">{{ $item->rfc }}</td>
                        <td class="is-vcentered">{{ $item->nombre }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $item->ap_paterno }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $item->ap_materno }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $item->curp }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $item->email }}</td>
                        <td class="is-vcentered">
                            <div class="field is-grouped is-grouped-centered">
                                <button class="button is-warning is-responsive js-modal-trigger mr-2" title="Editar" data-target="modal-{{ $item->id }}">  <i class="fa-solid fa-pen-to-square"></i>   </button>
                                
                                <form action="{{ route('DocenteEliminar', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-danger is-responsive" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <!-- Modal para editar los datos generales del Docente -->
                        <div id="modal-{{ $item->id }}" class="modal">
                            <div class="modal-background"></div>
                        
                            <div class="modal-content">
                            <div class="box">
                                <p class="title is-5 has-text-centered">Modificar Datos Generales del Docente</p>

                                <form method="POST" action="{{route('DocenteUpdate', $item->id)}}">
                                    @csrf
                                    @method('PATCH')

                                <div class="field">
                                    <label class="label">RFC</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtRFC" value="{{ $item->rfc }}" >
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-key"></i>
                                        </span>
                                    </div>

                                    <label class="label">Nombre</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtNombre" value="{{ $item->nombre }}">
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-font"></i>
                                        </span>
                                    </div>

                                    <label class="label">Apellido Paterno</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtAp_paterno" value="{{ $item->ap_paterno }}" >
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-bold"></i>
                                        </span>
                                    </div>

                                    <label class="label">Apellido Materno</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtAp_materno" value="{{ $item->ap_materno }}">
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-c"></i>
                                        </span>
                                    </div>

                                    <label class="label">CURP</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtCurp" value="{{ $item->curp }}" >
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-file"></i>
                                        </span>
                                    </div>

                                    <label class="label">Correo</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtEmail" value="{{ $item->email }}">
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-envelope"></i>
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
    <div id="modal-nvo-docente" class="modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Dar de alta a un Docente</p>
                <form method="POST" action="{{ route('DocentesCrear') }}">
                    @csrf
                    @method('POST')
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">RFC:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtRFC" value="{{ old('txtRFC') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtRFC')
                            <p class="help is-danger">Ingresa el RFC del docente</p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Nombre:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtNombre"
                                    value="{{ old('txtNombre') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-font"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtNombre')
                            <p class="help is-danger">Ingresa el nombre del docente</p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Apellido Paterno:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtAp_paterno"
                                    value="{{ old('txtAp_paterno') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-bold"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtAp_paterno')
                            <p class="help is-danger">Ingresa el apellido paterno del docente</p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Apellido Materno:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtAp_materno"
                                    value="{{ old('txtAp_materno') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-c"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtAp_materno')
                            <p class="help is-danger">Ingresa el apellido materno del docente</p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">CURP:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtCurp"
                                    value="{{ old('txtCurp') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-file"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtCurp')
                            <p class="help is-danger">Ingresa el curp del docente</p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Correo:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtEmail"
                                    value="{{ old('txtEmail') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtEmail')
                            <p class="help is-danger">Ingresa el correo del docente</p>
                        @enderror
                    </div>


                    <div class="has-text-centered">
                        <button class="button is-primary" type="submit"><i
                                class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar</button>
                    </div>
                </form>
                <!-- Your content -->
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!-- Este es el modal para crear un nuevo plan de estudio (fin) -->

    @if ($errors->has('txtRFC') || $errors->has('txtNombre') || $errors->has('txtAp_paterno') || $errors->has('txtAp_materno')
        || $errors->has('txtCurp') || $errors->has('txtEmail'))
        <script>
            document.getElementById('modal-nvo-docente').classList.add('is-active');
        </script>
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#Teachers').DataTable({
                "columnDefs": [
                    { orderable: false, searchable: false, target: [6] }
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