<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Información Escolar')</title>
    
    <!--Bulma Offline-->
    <link rel="stylesheet" href={{ asset('/css/bulma@0.9.4.css') }}>

    <!--Iconos (FontAwesome)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    
    <!--Icons Si algún icono no te carga, descomenta esta línea-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- JQuery JS -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <script src="/js/JQuery@3.7.1.js"></script>
    <!-- Select2 CSS -->
    <link rel="stylesheet" href={{ asset('/css/select2@4.1.0.css') }}>
    <!-- Select2 JS -->
    <script src="/js/select2@4.1.0.js"></script>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href={{ asset('/css/datatables.css') }}>
    <link rel="stylesheet" href={{ asset('/css/datatables.bulma.css') }}>
    <!-- DataTables JS -->
    <script src="/js/datatables.js"></script>
    <script src="/js/datatables.bulma.js"></script>

    <!--JavaScript-->
    <script src="/js/main.js"></script>

    <link rel="stylesheet" href={{ asset('/css/styles_plantilla.css') }}>

    <link rel="shortcut icon" href="/img/logo.jpg" />

    <script src="https://kit.fontawesome.com/ee9903c79f.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item"><img class="logo-nav" src="/img/logo.jpg"></a>
            <a href="{{ route('home') }}" class="navbar-item navbar-start"><i class="fas fa-home"
                    style="margin-right: 5px;"></i>Inicio</a>
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-item navbar-end is-pulled-right">
                <div class="dropdown is-right">
                    <div class="dropdown-trigger">
                        <button class="button btn-user" aria-haspopup="true" aria-controls="dropdown-menu">
                            <span class="user-cetech" style="text-transform: uppercase">{{ Auth::user()->name }}</span>
                            <span class="icon is-small"><i class="fas fa-angle-down" aria-hidden="true"></i></span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                        <div class="dropdown-content">
                            <a href="{{ route('changePassword') }}" class="button dropdown-item">Cambiar contraseña</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                                <button class="button dropdown-item">Cerrar sesión</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

</body>
<div class="container is-fluid">
    @yield('content')
</div>

</html>
