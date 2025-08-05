<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login -CETECH</title>

    <!--Bulma-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <!--Importar iconos-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('css/styles_login.css')}}">
</head>
<body>
  <nav>
    <div class="container">
        <div class="columns is-centered is-vcentered" style="height: 100vh;">
            <div class="column is-5">
                <div class="box">
                    <figure class="is-120x120">
                        <img src="{{asset('img/logo.jpg')}}" alt="Logo Tec">
                    </figure>

                    <h1 class="title is-5">Sistema Integral de Información</h1>
                    <div class="field">
                        <label class="label">Correo Institucional</label>
                        <div class="control has-icons-left">
                          <input class="input" type="email" placeholder="e.g. l21590271@sjuanrio.tecnm.mx">
                          <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                        </div>
                        <p class="help">Ingresa tu correo</p>
                    </div>

                    <div class="field">
                        <label class="label">Contraseña</label>
                        <div class="control has-icons-left">
                          <input class="input" type="password" placeholder="**********">
                          <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                        </div>
                        <p class="help">Ingresa tu contraseña</p>
                    </div>

                    <div class="field">
                        <div class="control">
                            <a href="{{route('home')}}"><button class="button is-success">Inicia sesión</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>