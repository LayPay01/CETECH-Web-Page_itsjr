@hasrole('alumno')
<div class="column is-4-desktop is-6-mobile is-half-tablet">
    <div class="box has-shadow">
        <h1 class="title is-6"><i class="fas fa-file-alt">&nbsp;Documentos </i> </h1>
        <p class="subtitle is-6">Sube tus documentos digitales.</p>
        <a class="button is-info">Acceder</a>
    </div>
</div>
<div class="column is-4-desktop is-6-mobile is-half-tablet">
    <div class="box has-shadow">
        <h1 class="title is-6"><i class="fas fa-chalkboard-teacher">&nbsp;Materias Inscritas </i> </h1>
        <p class="subtitle is-6">Consulta tus materias.</p>
        <a class="button is-info" href="{{route('alumnoGrupos', Auth::user()->alumno->id)}}">Acceder</a>
    </div>
</div>
@endhasrole