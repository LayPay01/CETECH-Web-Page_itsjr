@extends('layouts.plantilla')

@section('title', 'SIE - División - Planes de Estudio')

@section('content')
    <div class="container has-shadow has-background-white is-fullhd mb-5">
        <div class="column">
            <p class="title is-6 has-text-centered"><i class="fa-solid fa-graduation-cap"></i>&nbsp;Planes de Estudio</p>
        </div>
        
        <div>
            <p class="title is-4 has-text-centered">Gestión de Planes de Estudio y Especialidades</p>
            <hr>
        </div>

        <div class="buttons ml-2">
            <a href="{{ route('home') }}" class="button is-danger is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</a>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nvo-plan">
                <i class="fa-solid fa-plus"></i>&nbsp;Agregar Plan de Estudio</button>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nvo-esp">
                <i class="fa-solid fa-plus"></i>&nbsp;Agregar Especialidad</button>
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

        <div class="columns is-multiline px-2">
            <!-- ---------------------------------- Planes de estudio ---------------------------------- -->
            <div class="column is-full">
                <div class="box has-shadow">
                    
                    <div>
                        <p class="title is-5 mb-1 has-text-weight-bold">Planes de Estudio</p>                        
                    </div>

                    <table class='table is-fullwidth is-striped is-narrow is-hoverable'>
                        <thead>
                        <tr class="th is-selected has-text-black">
                            <th class="is-vcentered">Plan de estudio</th>
                            <th class="is-vcentered">Carrera</th>
                            <th class="has-text-centered is-vcentered">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($planes as $plan)
                                <tr>
                                    <td class="is-vcentered">{{ $plan->Clave_plan_estudio }}</td>
                                    <td class="is-vcentered">{{ $plan->Carrera }}</td>
                                    <td class="is-vcentered">
                                        <div class="field is-grouped is-grouped-centered ">
                                            <form action="{{route('divisionMateriasPlanes', $plan->id) }}" method="GET">
                                                <button type="submit" class="button is-info is-responsive mr-1" title="Ver Materias">
                                                    <i class="fa-solid fa-book"></i> &nbsp;Materias
                                                </button>
                                            </form>
                                            @if ($plan->Materias()->count() > 0)
                                            <form action="{{route('divisionGrupos', $plan->id) }}" method="GET">
                                                <button type="submit" class="button is-link is-responsive mr-1" title="Ver Grupos">
                                                    <i class="fa-solid fa-people-group"></i> &nbsp;Grupos
                                                </button>
                                            </form>
                                            @endif

                                            <button class="button is-warning is-responsive js-modal-trigger mr-1"
                                                title="Editar" data-target="modal-plan-{{ $plan->id }}" >
                                                    <i class="fa-solid fa-pen-to-square"></i>   </button>
                                            
                                            <form action="{{ route('PlanesEstudioEliminar', $plan->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="button is-danger is-responsive is-hidden" {{ $plan->especialidades->count() > 0 || $plan->materias->count() > 0 ? 'disabled' : '' }}
                                                    title="{{ $plan->especialidades->count() > 0 || $plan->materias->count() > 0 ? 'Cuenta con especialidades o materias asignadas' : 'Eliminar' }}"
                                                    onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <!-- Modal para editar los datos generales del Plan de Estudio -->
                                    <div id="modal-plan-{{ $plan->id }}" class="modal">
                                        <div class="modal-background"></div>
                                    
                                        <div class="modal-content">
                                        <div class="box">
                                            <p class="title is-5 has-text-centered">Modificar Plan de Estudio</p>
            
                                            <form method="POST" action="{{route('PlanesEstudioUpdate', $plan->id)}}">
                                                @csrf
                                                @method('PATCH')
            
                                            <div class="field">
                                                <label class="label">Clave de la Carrera</label>
                                                <div class="control has-icons-left">
                                                    <input class="input" type="text" name="txtClave1" value="{{ $plan->Clave_plan_estudio }}" >
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-key"></i>
                                                    </span>
                                                </div>
            
                                                <label class="label">Nombre de la Carrera</label>
                                                <div class="control has-icons-left">
                                                    <input class="input" type="text" name="txtCarrera" value="{{ $plan->Carrera }}">
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-graduation-cap"></i>
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
                                    <!-- Modal para editar los datos generales del Plan de Estudio (Fin) -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> 
            </div>
            <!-- ---------------------------------- Planes de estudio (Fin)---------------------------------- -->

            <!-- ---------------------------------- Especialidades ---------------------------------- -->
            <div class="column">
                <div class="box has-shadow">
                    <div>
                        <p class="title is-5 mb-2 has-text-weight-bold">Especialidades</p>
                    </div>

                    <table class='table is-fullwidth is-striped is-narrow is-hoverable'>
                        <thead>
                        <tr class="th is-selected has-text-black">
                            <th>Clave</th>
                            <th>Especialidad</th>
                            <th class="is-hidden-mobile">Carrera</th>
                            <th class="has-text-centered">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($especialidades as $especialidad)
                                <tr>
                                    <td class="is-vcentered">{{ $especialidad->clave_especialidad }}</td>
                                    <td class="is-vcentered">{{ $especialidad->especialidad }}</td>
                                    <td class="is-vcentered is-hidden-mobile">{{ $especialidad->plan_estudio->Carrera }}</td>
                                    <td class="is-vcentered">
                                        <div class="field is-grouped is-grouped-centered ">
                                            <button class="button is-warning is-responsive js-modal-trigger mr-2"
                                                title="Editar" data-target="modal-esp-{{ $especialidad->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>   </button>
                                            
                                            <form action="{{ route('EspecialidadEliminar', $especialidad->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="button is-danger is-responsive"
                                                    title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <!-- Modal para editar los datos generales del Plan de Estudio -->
                                    <div id="modal-esp-{{ $especialidad->id }}" class="modal">
                                        <div class="modal-background"></div>
                                    
                                        <div class="modal-content">
                                        <div class="box">
                                            <p class="title is-5 has-text-centered">Modificar Especialidad</p>
            
                                            <form method="POST" action="{{route('EspecialidadUpdate', $especialidad->id)}}">
                                                @csrf
                                                @method('PATCH')
                                                
                                            <div class="field">
                                                <div class="control">
                                                    <label class="label">Plan de Estudio:</label>
                                                    <div class="control has-icons-left">
                                                        <div class="select is-fullwidth" >
                                                            <select name='txtPlanEstudio'>
                                                                @foreach ($planes as $plan)
                                                                <option value="{{$plan->id}}" {{ $plan->id == $especialidad->plan_estudio_id ? 'selected' : '' }}>{{ $plan->Carrera }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <span class="icon is-small is-left">
                                                            <i class="fa-solid fa-graduation-cap"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Clave de la Especialidad:</label>
                                                <div class="control has-icons-left">
                                                    <input class="input" type="text" name="txtClaveEsp" value="{{ $especialidad->clave_especialidad }}" >
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-key"></i>
                                                    </span>
                                                </div>
            
                                                <label class="label">Nombre de la Especialidad:</label>
                                                <div class="control has-icons-left">
                                                    <input class="input" type="text" name="txtEspecialidad" value="{{ $especialidad->especialidad }}">
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-scroll"></i>
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
                                    <!-- Modal para editar los datos generales del Plan de Estudio (Fin) -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ---------------------------------- Especialidades (Fin) ---------------------------------- -->
        </div>
    </div>

    <!-- Este es el modal para crear un nuevo plan de estudio -->
    <div id="modal-nvo-plan" class="modal">
        <div class="modal-background"></div>
    
        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Agregar Plan de Estudio</p>
                <form method="POST" action="{{ route('PlanesEstudioCrear') }}">
                    @csrf
                    @method('POST')
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Clave del Plan de Estudios:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtClave" value="{{ old('txtClave') }}">
    
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtClave')
                            <p class="help is-danger">Ingresa la clave del plan de estudios</p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Nombre de la carrera:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtCarrera"
                                    value="{{ old('txtCarrera') }}">
    
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtCarrera')
                            <p class="help is-danger">Ingresa el nombre de la carrera</p>
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

    <!-- Este es el modal para crear una nueva especialidad -->
    <div id="modal-nvo-esp" class="modal">
        <div class="modal-background"></div>
    
        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Agregar Especialidad</p>
                <form method="POST" action="{{ route('EspecialidadCrear') }}">
                    @csrf
                    @method('POST')
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
                            <label class="label">Clave de la Especialidad:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtClaveEsp" value="{{ old('txtClaveEsp') }}">
    
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtClaveEsp')
                            <p class="help is-danger">Ingresa la clave la especialidad</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Nombre de la Especialidad:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtEspecialidad" value="{{ old('txtEspecialidad') }}">
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-scroll"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtEspecialidad')
                            <p class="help is-danger">Ingresa el nombre de la especialidad</p>
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
    <!-- Este es el modal para crear una nueva especialidad (fin) -->
    
    
    @if ($errors->has('txtClave') || $errors->has('txtCarrera'))
        <script>
            document.getElementById('modal-nvo-plan').classList.add('is-active');
        </script>
    @endif
    @if ($errors->has('txtClaveEsp') || $errors->has('txtEspecialidad') || $errors->has('txtPlanEstudio'))
        <script>
            document.getElementById('modal-nvo-esp').classList.add('is-active');
        </script>
    @endif
@endsection