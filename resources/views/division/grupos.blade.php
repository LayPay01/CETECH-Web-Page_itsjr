@extends('layouts.plantilla')

@section('title', 'SIE - División - Grupos')

@section('content')    
    <div class="box has-shadow">
        <p class="title is-5 has-text-centered"><i class="fa-solid fa-people-group"></i>&nbsp;{{$planes->Carrera}}</p>
        <div>
            <p class="title is-4 has-text-centered">Grupos</p>
            <hr>
        </div>

        <div class="buttons">
            <a href="{{ route('divisionPlanesEstudio') }}" class="button is-danger is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</a>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nvo-grupo"><i class="fa-solid fa-plus"></i>&nbsp;Nuevo Grupo</button>
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

        <table id="Group" class='table is-fullwidth is-striped is-narrow is-hoverable'>
            <thead>
            <tr class="th is-selected has-text-black">
                <th class="is-vcentered">Periodo</th>
                <th class="is-vcentered">Materia</th>
                <th class="is-vcentered has-text-centered">Semestre</th>
                <th class="is-vcentered has-text-centered">Grupo</th>
                <th class="is-vcentered has-text-centered is-hidden-mobile">Capacidad</th>
                <th class="is-vcentered">Docente</th>
                <th class="has-text-centered">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($planes->grupos as $grupo)
                    <tr>
                        <!-- <td class="is-vcentered">{/{ "20" . explode('/', $grupo->periodo->clave_periodo)[0] }} {/{ $grupo->periodo->nombre_periodo }} | <b>{/{ $grupo->periodo->estatus }}</b></td> -->
                        <td class="is-vcentered">{{ "20" . explode('/', $grupo->periodo->clave_periodo)[0] }} {{ $grupo->periodo->nombre_periodo }} | <b>{{ $grupo->periodo->estatus }}</b></td>
                        <td class="is-vcentered">{{ $grupo->materia->clave_materia }} {{ $grupo->materia->nombre }}</td>
                        <td class="is-vcentered has-text-centered">{{ $grupo->semestre }}</td>
                        <td class="is-vcentered has-text-centered">{{ $grupo->letra_grupo }}</td>
                        <td class="is-vcentered has-text-centered is-hidden-mobile">{{ $grupo->capacidad }}</td>
                        <td class="is-vcentered">{{ $grupo->docente->rfc }} {{ $grupo->docente->nombre }} {{ $grupo->docente->ap_paterno }} {{ $grupo->docente->ap_materno }}</td>
                        <td class="is-vcentered">
                            <div class="field is-grouped is-grouped-centered"> 
                                @if ($grupo->periodo->estatus == 'En Curso' || $grupo->periodo->estatus == 'Cerrado')
                                <form action="{{route('divisionAlumnosGrupos', $grupo->id) }}" method="GET">
                                    <button type="submit" class="button is-info is-responsive mr-1" title="Ver Alumnos">
                                        <i class="fa-regular fa-rectangle-list"></i>&nbsp;Ver
                                    </button>
                                </form>
                                @endif
                                <button class="button is-warning is-responsive js-modal-trigger mr-1"
                                                title="Editar" data-target="modal-gru-{{ $grupo->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>   </button>

                                <form action="{{ route('GrupoEliminar', $grupo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-danger is-responsive" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <!-- Modal para editar los datos generales del Grupo -->
                        <div id="modal-gru-{{ $grupo->id }}" class="modal">
                            <div class="modal-background"></div>
                        
                            <div class="modal-content">
                            <div class="box">
                                <p class="title is-5 has-text-centered">Modificar Grupo</p>

                                <form method="POST" action="{{route('GrupoUpdate', $grupo->id)}}">
                                    @csrf
                                    @method('PATCH')
                                    
                                <!-- <div class="field">
                                    <div class="control">
                                        <label class="label">Periodo:</label>
                                        <div class="control has-icons-left">
                                            <div class="select is-fullwidth" >
                                                <select name='txtPeriodo'>
                                                    @foreach ($periodos as $periodo)
                                                    <option value="{{$periodo->id}}" {{ $periodo->id == $grupo->periodo_id ? 'selected' : '' }}>{{ $periodo->clave_periodo }} - {{ $periodo->nombre_periodo }} | {{ $periodo->estatus }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="icon is-small is-left">
                                                <i class="fa-solid fa-p"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <label class="label">Materia:</label>
                                        <div class="control has-icons-left">
                                            <div class="is-fullwidth" >
                                                <select name='txtMateria' class="Materias">
                                                    @foreach ($materias as $materia)
                                                    <option value="{{$materia->id}}" {{ $materia->id == $grupo->materia_id ? 'selected' : '' }}>{{ $materia->clave_materia }} - {{ $materia->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="icon is-small is-left">
                                                <i class="fa-solid fa-address-card"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <label class="label">Semestre:</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="number" min="1" max="12" name="txtSemestre" value="{{ $grupo->semestre }}">
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-0"></i>
                                    </span>
                                </div>

                                <label class="label">Letra del Grupo:</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="text" name="txtLetra" value="{{ $grupo->letra_grupo }}" oninput="this.value = this.value.toUpperCase()">
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-font"></i>
                                    </span>
                                </div> -->

                                <label class="label">Capacidad (No.):</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="number" min="1" max="60" name="txtCapacidad" value="{{ $grupo->capacidad }}">
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-1"></i>
                                    </span>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <label class="label">Docente Designado:</label>
                                        <div class="control has-icons-left">
                                            <div class="select is-fullwidth" >
                                                <select name='txtDocente'>
                                                    @foreach ($docentes as $docente)
                                                    <option value="{{$docente->id}}" {{ $docente->id == $grupo->docente_id ? 'selected' : '' }}>{{ $docente->rfc }} - {{ $docente->nombre }} {{ $docente->ap_paterno }} {{ $docente->ap_materno }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="icon is-small is-left">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                            </span>
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
                        <!-- Modal para editar los datos generales del Grupo (Fin) -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Este es el modal para crear un nuevo grupo -->
    <div id="modal-nvo-grupo" class="modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Nuevo Grupo</p>
                <form method="POST" action="{{ route('GrupoCrear', $planes->id) }}">
                    @csrf
                    @method('POST')

                    <div class="field">
                        <div class="control">
                            <label class="label">Periodo:</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth" >
                                    <select name='txtPeriodo'>
                                        <option value="">Selecciona un Periodo</option>
                                        @foreach ($periodos as $periodo)
                                            <option value="{{$periodo->id}}">
                                                {{ $periodo->clave_periodo }} - {{ $periodo->nombre_periodo }} | {{ $periodo->estatus }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-p"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @error('txtPeriodo')
                            <p class="help is-danger">Debes seleccionar un Periodo</p>
                        @enderror
                    </div>

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
                            <label class="label">Grupo:</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth" >
                                    <select name='txtLetra'>
                                        <option value="">Selecciona un Grupo</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                    </select>
                                </div>
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-g"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtLetra')
                            <p class="help is-danger">Selecciona un grupo</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Capacidad (No.):</label>
                            <div class="control has-icons-left">
                                <input class="input" type="number" min="1" max="60" name = "txtCapacidad"
                                    value="{{ old('txtCapacidad') }}">

                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-1"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtCapacidad')
                            <p class="help is-danger">Ingresa la capacidad máxima del grupo</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="label">Docente Designado:</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth" >
                                    <select name='txtDocente'>
                                        <option value="">Selecciona un Docente</option>
                                        @foreach ($docentes as $docente)
                                            <option value="{{$docente->id}}">
                                                {{ $docente->rfc }} - {{ $docente->nombre }} {{ $docente->ap_paterno }} {{ $docente->ap_materno }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @error('txtDocente')
                            <p class="help is-danger">Debes seleccionar un Docente</p>
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
    <!-- Este es el modal para crear un nuevo grupo (fin) -->

    @if ($errors->has('txtPeriodo') || $errors->has('txtMateria') || $errors->has('txtSemestre') || 
        $errors->has('txtLetra') || $errors->has('txtCapacidad') || $errors->has('txtDocente'))
        <script>
            document.getElementById('modal-nvo-grupo').classList.add('is-active');
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('select.Materias').select2();
            var table = $('#Group').DataTable({
                "columnDefs": [
                    { orderable: false, searchable: false, target: [0, 4, 5, 6] },
                    { searchable: false, target: [2, 3] },
                ],
                lengthMenu: [5, 10, 25, 50],
                language: {
                    url: '/js/es-MX.js',
                },
            });
            table.order([1, 'asc']).draw();
        });

        $('select[name="txtMateria"]').on('change', function() {
            var planId = {{ $planes->id }}; 
            var materiaId = $(this).val();
            $.get('/plan/' + planId + '/materia/' + materiaId + '/grupos', function(data) {
                var gruposAsignados = data;
                $('select[name="txtLetra"] option').each(function() {
                    var grupo = $(this).val();
                    if (gruposAsignados.includes(grupo)) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });
    </script>
@endsection