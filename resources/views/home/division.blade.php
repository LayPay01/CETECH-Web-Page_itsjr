@hasrole('division')
<div class="column is-4-desktop is-6-mobile is-half-tablet">
    <div class="box has-shadow">
        <h1 class="title is-6"><i class="fa-solid fa-book">&nbsp;Materias </i> </h1>
        <p class="subtitle is-6">Ver, crear, editar materias</p>
        <a class="button is-info" href="{{route('divisionMaterias')}}">Acceder</a>
    </div>
</div>
<div class="column is-4-desktop is-6-mobile is-half-tablet">
    <div class="box has-shadow">
        <h1 class="title is-6"><i class="fa-solid fa-graduation-cap">&nbsp;Planes de Estudio </i> </h1>
        <p class="subtitle is-6">Gestión planes de estudio, materias y grupos</p>
        <a class="button is-info" href="{{route('divisionPlanesEstudio')}}">Acceder</a>
    </div>
</div>
@endhasrole