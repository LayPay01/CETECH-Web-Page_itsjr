@extends('layouts.plantilla')

@section('title', 'SIE - Escolares - Periodos')

@section('content')
<style>
    .en-curso {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var date = new Date();
        var year = date.getFullYear().toString().substr(-2); // Obtén solo los dos últimos dígitos del año
        var month = date.getMonth() + 1; // Los meses en JavaScript empiezan en 0
        var day = date.getDate();
        var period;

        if ((month == 1 && day >= 20) || (month > 1 && month < 6) || (month == 6 && day <= 1)) {
            period = year + "/1";
        } else if ((month == 8 && day >= 15) || (month > 8 && month < 12) || (month == 12 && day <= 15)) {
            period = year + "/2";
        } else {
            period = year + "/v";
        }

        var selects = document.getElementsByClassName('txtClave');

        for (var i = 0; i < selects.length; i++) {
            var select = selects[i];

            if (select.name === 'txtClave') {
                select.options[select.options.length] = new Option(period, period);
            }

            // Agrega las otras opciones solo si no son iguales al periodo actual
            if (period !== year + "/1") {
                select.options[select.options.length] = new Option(year + "/1", year + "/1");
            }
            if (period !== year + "/2") {
                select.options[select.options.length] = new Option(year + "/2", year + "/2");
            }
            if (period !== year + "/v") {
                select.options[select.options.length] = new Option(year + "/v", year + "/v");
            }
        }

        select.addEventListener('change', function() {
            var nombrePeriodoInput = document.getElementById('txtNombre');
            switch (this.value) {
                case '24/1':
                    nombrePeriodoInput.value = 'Enero-Junio';
                    break;
                case '24/2':
                    nombrePeriodoInput.value = 'Agosto-Diciembre';
                    break;
                case '24/v':
                    nombrePeriodoInput.value = 'Verano';
                    break;
                default:
                    nombrePeriodoInput.value = '';
            }
        });
    });
</script>

    <div class="box has-shadow">
        <p class="title is-6 has-text-centered"><i class="fa-solid fa-user-group"></i>&nbsp;Periodos</p>
        <div>
            <p class="title is-4 has-text-centered">Gestión de Periodos</p>
            <hr>
        </div>

        <div class="buttons">
            <a href="{{ route('home') }}" class="button is-danger is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</a>
            <button class="button is-primary is-responsive js-modal-trigger" data-target="modal-nvo-periodo"><i class="fa-solid fa-plus"></i>&nbsp;Nuevo Periodo</button>
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
                <th class="is-vcentered ">Clave</th>
                <th class="is-vcentered ">Periodo</th>
                <th class="is-vcentered ">Estatus</th>
                <th class="has-text-centered">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($periodos as $periodo)
                    <tr>
                        <td class="is-vcentered">{{ $periodo->clave_periodo }}</td>
                        <td class="is-vcentered">{{ $periodo->nombre_periodo }}</td>
                        <td class="is-vcentered">{{ $periodo->estatus }}</td>
                        <td class="is-vcentered">
                            <div class="field is-grouped is-grouped-centered">
                                <button class="button is-warning is-responsive js-modal-trigger mr-2" title="Editar" data-target="modal-{{ $periodo->id }}">  <i class="fa-solid fa-pen-to-square"></i>   </button>
                                
                                <form action="{{ route('PeriodoEliminar', $periodo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button is-danger is-responsive" title="Eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este registro?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <!-- Modal para editar los datos generales del Docente -->
                        <div id="modal-{{ $periodo->id }}" class="modal">
                            <div class="modal-background"></div>
                        
                            <div class="modal-content">
                            <div class="box">
                                <p class="title is-5 has-text-centered">Modificar el Estatus del Periodo "{{ $periodo->clave_periodo }}"</p>

                                <form method="POST" action="{{route('PeriodoUpdate', $periodo->id)}}">
                                    @csrf
                                    @method('PATCH')

                                <div class="field">

                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Estatus:</label>
                                            <div class="control has-icons-left">
                                                <div class="select is-fullwidth" >
                                                    <select name='txtEstatus'>
                                                        <option value="En Curso" {{ $periodo->estatus == 'En Curso' ? 'selected' : '' }}>En Curso</option>
                                                        <option value="Cerrado" {{ $periodo->estatus == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                                        <option value="Preparación" {{ $periodo->estatus == 'Preparación' ? 'selected' : '' }}>Preparación</option>
                                                    </select>
                                                </div>
                                                <span class="icon is-small is-left">
                                                    <i class="fa-solid fa-e"></i>
                                                </span>
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

    <!-- Este es el modal para crear un nuevo periodo -->
    <div id="modal-nvo-periodo" class="modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <p class="title is-5 has-text-centered">Nuevo Periodo</p>
                <form method="POST" action="{{ route('PeriodoCrear') }}">
                    @csrf
                    @method('POST')
                    
                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Periodo:</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth" >
                                    <select class="txtClave" id='txtClave' name='txtClave'>
                                        <option value="">Selecciona un Periodo</option>
                                    </select>
                                </div>
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtClave')
                            <p class="help is-danger">Debes seleccionar un periodo</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control has-icons-left">
                            <label class="label">Nombre del periodo:</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="Debes seleccionar un periodo" readonly 
                                 id="txtNombre" name = "txtNombre" value="{{ old('txtNombre') }}">
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-font"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtNombre')
                            <p class="help is-danger">Selecciona un periodo</p>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="label">Estatus:</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth" >
                                    <select name='txtEstatus'>
                                        <option value="">Selecciona un Estatus</option>
                                        <option value="En Curso" class="en-curso">En Curso</option>
                                        <option value="Cerrado">Cerrado</option>
                                        <option value="Preparación">Preparación</option>
                                    </select>
                                </div>
                                <span class="icon is-small is-left">
                                    <i class="fa-solid fa-e"></i>
                                </span>
                            </div>
                        </div>
                        @error('txtEstatus')
                            <p class="help is-danger">Debes seleccionar un estatus</p>
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
    <!-- Este es el modal para crear un nuevo periodo (fin) -->

    @if ($errors->has('txtClave') || $errors->has('txtNombre') || $errors->has('txtEstatus'))
        <script>
            document.getElementById('modal-nvo-periodo').classList.add('is-active');
        </script>
    @endif

    <script>
        $('#modal-nvo-periodo').on('click', function() {
            $.get('/escolares/periodos/estatus', function(data) {
                var estatusEnCursoExiste = data.includes('En Curso');
                if (!estatusEnCursoExiste) {
                    $('select[name="txtEstatus"] option.en-curso').show();
                }
            });
        });
    </script>
@endsection