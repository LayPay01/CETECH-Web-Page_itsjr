@extends('layouts.plantilla')

@section('title', 'SIE - Escolares - Alumnos')

@section('content')
    <div class="box has-shadow">
        <p class="title is-6 has-text-centered"><i class="fa-solid fa-user-group"></i>&nbsp;Alumnos</p>
        <div>
            <p class="title is-4 has-text-centered">Gestión de Alumnos</p>
            <hr>
        </div>

        <div class="buttons">
            <a href="{{ route('home') }}" class="button is-danger is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</a>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nvo-alumno"><i class="fa-solid fa-plus"></i>&nbsp;Alta de Alumno</button>
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

        <table id="Alumns" class='table is-fullwidth is-striped is-narrow is-hoverable'>
            <thead>
            <tr class="th is-selected has-text-black">
                <th class="is-vcentered " title="Número de Control">NC</th>
                <th class="is-vcentered ">Nombre</th>
                <th class="is-vcentered is-hidden-mobile">Apellido Paterno</th>
                <th class="is-vcentered is-hidden-mobile">Apellido Materno</th>
                <th class="is-vcentered is-hidden-mobile">CURP</th>
                <th class="is-vcentered is-hidden-mobile">Carrera</th>
                <th class="is-vcentered ">Semestre</th>
                <th class="is-vcentered is-hidden-mobile">Estatus</th>
                <th class="is-vcentered is-hidden-mobile">Tipo</th>
                <th class="is-vcentered has-text-centered">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($alumnos as $alumno)
                    <tr>
                        <td class="is-vcentered">{{ $alumno->numero_de_control }}</td>
                        <td class="is-vcentered">{{ $alumno->nombre }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $alumno->ap_paterno }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $alumno->ap_materno }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $alumno->curp }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $alumno->plan_estudio->Carrera }}</td>
                        <td class="is-vcentered has-text-centered">{{ $alumno->semestre }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $alumno->estatus->nombre_estatus }}</td>
                        <td class="is-hidden-mobile is-vcentered">{{ $alumno->tipo_alumno->nombre_tipo }}</td>
                        <td class="is-vcentered">
                            <div class="field is-grouped is-grouped-centered">
                                <button class="button is-warning is-responsive js-modal-trigger mr-2" title="Editar" data-target="modal-{{ $alumno->id }}">  <i class="fa-solid fa-pen-to-square"></i>   </button>
                                
                                <form action="{{ route('AlumnoEliminar', $alumno->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-danger is-responsive" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <!-- Modal para editar los datos generales del Docente -->
                        <div id="modal-{{ $alumno->id }}" class="modal">
                            <div class="modal-background"></div>
                        
                            <div class="modal-content">
                            <div class="box">
                                <p class="title is-5 has-text-centered">Modificar Datos Generales del Alumno</p>

                                <form method="POST" action="{{route('AlumnoUpdate', $alumno->id)}}">
                                    @csrf
                                    @method('PATCH')

                                <div class="field">
                                    <!-- <label class="label">Número de Control:</label>
                                    <div class="control">
                                        <input class="input" type="text" name="txtNC" value="{{ $alumno->numero_de_control }}" >
                                    </div> -->

                                    <label class="label">Nombre:</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtNombre" value="{{ $alumno->nombre }}">
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-font"></i>
                                        </span>
                                    </div>

                                    <label class="label">Apellido Paterno:</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtAp_paterno" value="{{ $alumno->ap_paterno }}" >
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-bold"></i>
                                        </span>
                                    </div>

                                    <label class="label">Apellido Materno:</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtAp_materno" value="{{ $alumno->ap_materno }}">
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-c"></i>
                                        </span>
                                    </div>

                                    <label class="label">CURP:</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="txtCurp" value="{{ $alumno->curp }}" >
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-file"></i>
                                        </span>
                                    </div>

                                    <div class="field">
                                        <div class="control has-icons-left">
                                            <label class="label">Plan de Estudio:</label>
                                            <div class="control">
                                                <div class="select is-fullwidth" >
                                                    <select name='txtPlanEstudio'>
                                                        @foreach ($planes as $plan)
                                                        <option value="{{$plan->id}}" {{ $plan->id == $alumno->plan_estudio_id ? 'selected' : '' }}>{{ $plan->Carrera }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-graduation-cap"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <label class="label">Semestre:</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="number" min="1" max="12" name="txtSemestre" value="{{ $alumno->semestre }}">
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-0"></i>
                                        </span>
                                    </div>

                                    <div class="field">
                                        <div class="control has-icons-left">
                                            <label class="label">Estatus:</label>
                                            <div class="control">
                                                <div class="select is-fullwidth" >
                                                    <select name='txtEstatus'>
                                                        @foreach ($estatuses as $estatus)
                                                        <option value="{{$estatus->id}}" {{ $estatus->id == $alumno->estatus_id ? 'selected' : '' }}>{{ $estatus->nombre_estatus }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-e"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="control has-icons-left">
                                            <label class="label">Tipo:</label>
                                            <div class="control">
                                                <div class="select is-fullwidth" >
                                                    <select name='txtTipo'>
                                                        @foreach ($tipos as $tipo)
                                                        <option value="{{$tipo->id}}" {{ $tipo->id == $alumno->tipo_alumno_id ? 'selected' : '' }}>{{ $tipo->nombre_tipo }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-t"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
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
    <div id="modal-nvo-alumno" class="modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Dar de alta a un Alumno</p>
                <form method="POST" action="{{ route('AlumnoCrear') }}">
                    @csrf
                    @method('POST')
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Número de control:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtNC" value="{{ old('txtNC') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtNC')
                            <p class="help is-danger">Ingresa el número de control</p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Nombre del Alumno:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtNombre"
                                    value="{{ old('txtNombre') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-font"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtNombre')
                            <p class="help is-danger">Ingresa el nombre del alumno</p>
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
                            <p class="help is-danger">Ingresa el apellido paterno</p>
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
                            <p class="help is-danger">Ingresa el apellido materno</p>
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
                            <p class="help is-danger">Ingresa la curp</p>
                        @enderror
                    </div>
                    
                    <div class="field">
                        <div class="control">
                            <label class="label">Plan de Estudio:</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth" >
                                    <select name='txtPlanEstudio'>
                                        <option value="">Selecciona un Plan de Estudio</option>
                                        @foreach ($planes as $plan)
                                            <option value="{{$plan->id}}">{{ $plan->Carrera }}</option>
                                        @endforeach
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @error('txtPlanEstudio')
                            <p class="help is-danger">Debes seleccionar un plan de estudio</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Semestre:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="number" min="1" max="12" name = "txtSemestre"
                                    value="{{ old('txtSemestre') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-0"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtSemestre')
                            <p class="help is-danger">Ingresa el número del semestre</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="label">Estatus:</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth" >
                                    <select name='txtEstatus'>
                                        <option value="">Selecciona un Estatus</option>
                                        @foreach ($estatuses as $estatus)
                                            <option value="{{$estatus->id}}">{{ $estatus->nombre_estatus }}</option>
                                        @endforeach
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-e"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @error('txtPlanEstudio')
                            <p class="help is-danger">Debes seleccionar un estatus</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="label">Tipo:</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth" >
                                    <select name='txtTipo'>
                                        <option value="">Selecciona un Tipo</option>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{$tipo->id}}">{{ $tipo->nombre_tipo }}</option>
                                        @endforeach
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-t"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @error('txtPlanEstudio')
                            <p class="help is-danger">Debes seleccionar un tipo para el alumno</p>
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

    @if ($errors->has('txtNC') || $errors->has('txtNombre') || $errors->has('txtAp_paterno') || $errors->has('txtAp_materno')
        || $errors->has('txtCurp') || $errors->has('txtPlanEstudio') || $errors->has('txtSemestre')
        || $errors->has('txtEstatus') || $errors->has('txtTipo'))
        <script>
            document.getElementById('modal-nvo-alumno').classList.add('is-active');
        </script>
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#Alumns').DataTable({
                columnDefs : [
                    { orderable: false, searchable: false, target: [1, 4, 9] },
                    { searchable: false, target: [2, 3, 5, 6, 7, 8] }
                ],
                lengthMenu: [5, 10, 25, 50],
                language: {
                    url: '/js/es-MX.js',
                },
            });
            table.order([1, 'asc']).draw();
        });

        // Tiempo de carga de datatables
        /* console.time("DataTables Load Time");
        $(document).ready(function() {
            var table = $('#Alumns').DataTable({
                columnDefs : [
                    { orderable: false, searchable: false, target: [6] }
                ],
                lengthMenu: [5, 10, 25, 50],
                language: {
                    url: '/js/es-MX.js',
                },
                initComplete: function() {
                    console.timeEnd("DataTables Load Time");
                },
            });
            table.order([1, 'asc']).draw();
        }); */
    </script>
@endsection
