@extends('layouts.plantilla')

@section('title')
SIE - {{ $grupos->materia->nombre }} - Gpo: {{ $grupos->letra_grupo }}
@endsection


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
            &nbsp;{{$grupos->materia->nombre}} - Gpo: {{$grupos->letra_grupo}}</p>
        <div>
            <p class="title is-4 has-text-centered">Lista de Alumnos</p>
            <hr>
        </div>

        <div class="buttons">
            <button onclick="goBack()" class="button is-danger back is-responsive"><i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar</button>
        </div>

        <table id="Alumns" class='table is-fullwidth is-striped is-narrow is-hoverable'>
            <thead>
            <tr class="th is-selected has-text-black">
                <th class="is-vcentered">No. Control</th>
                <th class="is-vcentered">Apellidos</th>
                <th class="is-vcentered">Nombres</th>
                <th class="is-vcentered has-text-centered">Semestre</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($grupos->Alumno as $alumno)
                    <tr>
                        <td class="is-vcentered">{{ $alumno->numero_de_control }}</td>
                        <td class="is-vcentered">{{ $alumno->ap_paterno }} {{ $alumno->ap_materno }}</td>
                        <td class="is-vcentered">{{ $alumno->nombre }}</td>
                        <td class="is-vcentered has-text-centered">{{ $alumno->semestre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#Alumns').DataTable({
                buttons: [
                    {
                        extend: "pdfHtml5",
                        text: "<i class='fa-solid fa-file-pdf'></i>",
                        titleAttr: "Exportar PDF",
                        className: "button is-danger",
                        customize: function (doc) {
                            // Establece el layout para que ocupe todo el ancho
                            doc.defaultStyle.alignment = 'justify';
                            doc.styles.tableHeader.alignment = 'justify';

                            // Elimina los encabezados originales
                            doc.content[1].table.body.shift();

                            // Agrega una columna extra al final de cada fila
                            doc.content[1].table.body.forEach(function(row) {
                                // Centra el contenido de la columna "Semestre"
                                row[3] = { text: row[3], alignment: 'center' };                             
                                // Agrega la columna "Firma"
                                row.push({ text: "", style: "signature" });
                            });

                            // Agrega el encabezado de la columna extra
                            doc.content[1].table.body.unshift([
                                { text: "No. Control", style: "tableHeader" },
                                { text: "Apellidos", style: "tableHeader" },
                                { text: "Nombres", style: "tableHeader" },
                                { text: "Semestre", style: "tableHeader", alignment: 'center' },
                                { text: "Firma", style: "tableHeader", alignment: 'center' },
                            ]);

                            doc.content[1].table.widths = 
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        },
                    },
                ],
                columnDefs : [
                    { orderable: false, searchable: false, target: [3] },
                    { orderable: false, target: [2] },
                ],
                lengthMenu: [5, 10, 25, 50],
                language: {
                    url: '/js/es-MX.js',
                },
            });
            table.order([1, 'asc']).draw();
            
            setTimeout(function() {
                if ($('.buttons').length) {
                    console.log('El contenedor .buttons existe en el DOM.');
                    table.buttons().container().appendTo('.buttons');
                    console.log('Botones de exportación agregados.');
                } else {
                    console.log('El contenedor .buttons NO existe en el DOM.');
                }
            }, 500);
        });
    </script>
@endsection