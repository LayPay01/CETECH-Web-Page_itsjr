@extends('layouts.plantilla')

@section('title', 'SIE - Escolares - Edificios y Salones')

@section('content')
    <div class="container has-shadow has-background-white is-fullhd mb-5">
        <div class="column">
            <p class="title is-6 has-text-centered"><i class="fa-solid fa-building"></i>&nbsp;Edificios y Salones</p>
        </div>
        
        <div>
            <p class="title is-4 has-text-centered">Gestión de Edificios y Salones</p>
            <hr>
        </div>

        <div class="buttons ml-2">
            <a href="{{ route('home') }}" class="button is-danger is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</a>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nvo-edificio"><i class="fa-solid fa-plus"></i>&nbsp;Agregar Edificio</button>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nvo-salon"><i class="fa-solid fa-plus"></i>&nbsp;Agregar Salón</button>
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

        <div class="columns is-multiline px-2">
            <div class="column is-half">
                <div class="box has-shadow">
                    <div>
                        <p class="title is-5 mb-2 has-text-weight-bold">Edificios</p>
                    </div>
            
                    <table class='table is-fullwidth is-striped is-narrow is-hoverable'>
                        <thead>
                        <tr class="th is-selected has-text-black">
                            <th>Edificio</th>
                            <th>Descripción</th>
                            <th class="has-text-centered">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($edificios as $edificio)
                                <tr>
                                    <td class="is-vcentered">{{ $edificio->nombre_edificio }}</td>
                                    <td class="is-vcentered">{{ $edificio->descripcion }}</td>
                                    <td class="is-vcentered">
                                        <div class="field is-grouped is-grouped-centered ">
                                            <button class="button is-warning is-responsive js-modal-trigger mr-2" title="Editar" data-target="modal-edificio-{{ $edificio->id }}">  <i class="fa-solid fa-pen-to-square"></i>   </button>
                                            
                                            <form action="{{ route('EdificioEliminar', $edificio->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="button is-danger is-responsive" {{ $edificio->salones->count() > 0 ? 'disabled' : '' }}
                                                    title="{{ $edificio->salones->count() > 0 ? 'Cuenta con salones asignados' : 'Eliminar' }}"
                                                    onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    
                                    <!-- Modal para editar los datos generales del Edificio -->
                                    <div id="modal-edificio-{{ $edificio->id }}" class="modal">
                                        <div class="modal-background"></div>
                                        
                                        <div class="modal-content">
                                            <div class="box">
                                            <p class="title is-5 has-text-centered">Modificar Nombre del Edificio</p>

                                            <form method="POST" action="{{route('EdificioUpdate', $edificio->id)}}">
                                                @csrf
                                                @method('PATCH')

                                            <div class="field">
                                                <label class="label">Nombre del Edificio</label>
                                                <div class="control has-icons-left">
                                                    <input class="input" type="text" name="txtNombreEdificio" value="{{ $edificio->nombre_edificio }}" >
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-building"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label class="label">Descripción</label>
                                                <div class="control has-icons-left">
                                                    <input class="input" type="text" name="txtDescripcion" value="{{ $edificio->descripcion }}" >
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-d"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="has-text-centered">
                                                <button class="button is-primary" type="submit"  onclick="return confirm('¿Estás seguro de querer actualizar este registro?')">Actualizar</button>
                                            </div>
                                            </form>

                                            </div>
                                        </div>
                                        
                                        <button class="modal-close is-large" aria-label="close"></button>
                                    </div>
                                    <!-- Modal para editar los datos generales del Edificio (Fin) -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            
                </div>
            </div>
            
            <!-- ---------------------------------- Salones ---------------------------------- -->

            <div class="column is-half">
                <div class="box has-shadow">
                    <div>
                        <p class="title is-5 mb-2 has-text-weight-bold">Salones</p>
                    </div>

                    <table class='table is-fullwidth is-striped is-narrow is-hoverable'>
                        <thead>
                        <tr class="th is-selected has-text-black">
                            <th>Salón</th>
                            <th>Edificio</th>
                            <th class="has-text-centered">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($salones as $salon)
                                <tr>
                                    <td class="is-vcentered">{{ $salon->nombre_salon}}</td>
                                    <td class="is-vcentered">{{ $salon->edificio->nombre_edificio}}</td>
                                    <td class="is-vcentered">
                                        <div class="field is-grouped is-grouped-centered ">
                                            <button class="button is-warning is-responsive js-modal-trigger mr-2" title="Editar" data-target="modal-salon-{{ $salon->id }}">  <i class="fa-solid fa-pen-to-square"></i>   </button>
                                            
                                            <form action="{{ route('SalonEliminar', $salon->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="button is-danger is-responsive" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <!-- Modal para editar los datos generales del Salón -->
                                    <div id="modal-salon-{{ $salon->id }}" class="modal">
                                        <div class="modal-background"></div>
                                        
                                        <div class="modal-content">
                                            <div class="box">
                                            <p class="title is-5 has-text-centered">Modificar parámetros del Salón</p>

                                            <form method="POST" action="{{route('SalonUpdate', $salon->id)}}">
                                                @csrf
                                                @method('PATCH')

                                            <div class="field">
                                                <div class="control">
                                                    <label class="label">Edificio:</label>
                                                    <div class="control has-icons-left">
                                                        <div class="select is-fullwidth" >
                                                            <select name='txtEdificio'>
                                                                @foreach ($edificios as $edificio)
                                                                <option value="{{$edificio->id}}" {{ $edificio->id == $salon->edificio_id ? 'selected' : '' }}>{{ $edificio->nombre_edificio }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="icon is-small is-left">
                                                                <i class="fa-solid fa-building"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label class="label">Nombre del Salón</label>
                                                <div class="control has-icons-left">
                                                    <input class="input" type="text" name="txtNombreSalon" value="{{ $salon->nombre_salon }}" >
                                                    <span class="icon is-small is-left">
                                                        <i class="fa-solid fa-chalkboard"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="has-text-centered">
                                                <button class="button is-primary" type="submit"  onclick="return confirm('¿Estás seguro de querer actualizar este registro?')">Actualizar</button>
                                            </div>
                                            </form>

                                            </div>
                                        </div>
                                        
                                        <button class="modal-close is-large" aria-label="close"></button>
                                    </div>
                                    <!-- Modal para editar los datos generales del Salón (Fin) -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

    <!-- Este es el modal para agregar un nuevo edificio -->
    <div id="modal-nvo-edificio" class="modal">
        <div class="modal-background"></div>
    
        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Agregar Edificio</p>
                <form method="POST" action="{{ route('EdificioCrear') }}">
                    @csrf
                    @method('POST')
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Nombre del Edificio:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtNombreEdificio" value="{{ old('txtNombreEdificio') }}">
    
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-building"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtNombreEdificio')
                            <p class="help is-danger">Ingresa el nombre del edificio</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Descripción del Edificio:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtDescripcion" value="{{ old('txtDescripcion') }}">
    
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-d"></i>
                                </span>
                            </div>
                        </div>
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
    <!-- Este es el modal para agregar un nuevo edificio (fin) -->

    <!-- Este es el modal para agregar un nuevo salón -->
    <div id="modal-nvo-salon" class="modal">
        <div class="modal-background"></div>
    
        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Agregar Salón</p>
                <form method="POST" action="{{ route('SalonCrear') }}">
                    @csrf
                    @method('POST')
                    <div class="field">
                        <div class="control">
                            <label class="label">Edificio:</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth" >
                                    <select name='txtEdificio'>
                                        <option value="">Selecciona un Edificio</option>
                                        @foreach ($edificios as $edificio)
                                            <option value="{{$edificio->id}}">{{ $edificio->nombre_edificio }}</option>
                                        @endforeach
                                    </select>
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-building"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @error('txtEdificio')
                            <p class="help is-danger">Debes seleccionar un edificio</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Nombre del Salón:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name = "txtNombreSalon" value="{{ old('txtNombreSalon') }}">
    
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-chalkboard"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtNombreSalon')
                            <p class="help is-danger">Ingresa el nombre del salón</p>
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
    <!-- Este es el modal para agregar un nuevo salón (fin) -->
    
    @if ($errors->has('txtNombreEdificio'))
        <script>
            document.getElementById('modal-nvo-edificio').classList.add('is-active');
        </script>
    @endif
    @if ($errors->has('txtNombreSalon') || $errors->has('txtEdificio'))
        <script>
            document.getElementById('modal-nvo-salon').classList.add('is-active');
        </script>
    @endif
@endsection