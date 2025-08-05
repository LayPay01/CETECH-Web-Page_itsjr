@extends('layouts.plantilla')

@section('title', 'SIE - Docente - Grupos')

@section('content')
    <div class="box has-shadow">
        <p class="title is-6 has-text-centered"><i class="fa-solid fa-users-rectangle"></i>&nbsp;Listas</p>
        <div>
            <p class="title is-4 has-text-centered">Grupos Asignados</p>
            <hr>
        </div>

        <div class="buttons">
            <button onclick="goBack()" class="button is-danger back is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</button>
        </div>

        <table id="groups" class='table is-fullwidth is-striped is-narrow is-hoverable'>
            <thead>
            <tr class="th is-selected has-text-black">
                <th class="is-vcentered">Periodo</th>
                <th class="is-vcentered">Plan de Estudio</th>
                <th class="is-vcentered">Materia</th>
                <th class="is-vcentered has-text-centered">Grupo</th>
                <th class="is-vcentered has-text-centered">Opciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($docentes->Grupo as $grupo)
                    @if ($grupo->periodo->estatus == 'En Curso')
                        <tr>
                            <td class="is-vcentered">{{ "20" . explode('/', $grupo->periodo->clave_periodo)[0] }} {{ $grupo->periodo->nombre_periodo }}</b></td>
                            <td class="is-vcentered">{{ $grupo->plan_estudio->Carrera }}</td>
                            <td class="is-vcentered">{{ $grupo->Materia->nombre }}</td>
                            <td class="is-vcentered has-text-centered">{{ $grupo->semestre}}{{ $grupo->letra_grupo}}</td>
                            <td class="is-vcentered">
                                <div class="field is-grouped is-grouped-centered">
                                    <form action="{{route('docenteAlumnosGrupos', $grupo->id) }}" method="GET">
                                        <button class="button is-info is-responsive js-modal-trigger mr-2" title="Listado de Alumnos">
                                            <i class="fa-regular fa-rectangle-list"></i>&nbsp;Ver</button>
                                    </form>
                                </div>
                                
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#groups').DataTable({
                columnDefs : [
                    { orderable: false, searchable: false, target: [0, 3, 4] }
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