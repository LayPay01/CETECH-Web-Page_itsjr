@hasrole('docente')
<div class="column is-4-desktop is-6-mobile is-half-tablet">
    <div class="box has-shadow">
        <h1 class="title is-6"><i class="fa-solid fa-users-rectangle"></i>&nbsp;Listas </i> </h1>
        <p class="subtitle is-6">Ver listas de grupos</p>
        <a class="button is-info" href="{{route('docenteGrupos', Auth::user()->docente->id)}}">Acceder</a>
    </div>
</div>
<div class="column is-4-desktop is-6-mobile is-half-tablet">
    <div class="box has-shadow">
        <h1 class="title is-6"><i class="fa-solid fa-graduation-cap">&nbsp;Calificaciones </i> </h1>
        <p class="subtitle is-6">Subir calificaciones</p>
        <a class="button is-info">Acceder</a>
    </div>
</div>
@endhasrole