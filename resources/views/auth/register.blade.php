<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="icon" href="{{ asset('img/logo.jpg') }}">
        <title>Registro</title>
        <!--Bulma-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

        <!--Modal-->
        <script src="/js/main.js"></script>

        <link rel="stylesheet" href={{ asset('/css/styles_plantilla_log.css') }}>
        
        <script src="https://kit.fontawesome.com/ee9903c79f.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div class="columns is-centered is-vcentered" style="height: 100vh;">
                <div class="column is-half">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">{{ __('Registro de nuevo usuario') }}</p>
                        </header>
        
                        <div class="card-content">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
        
                                <div class="field">
                                    <label for="name" class="label">{{ __('Nombre') }}</label>
                                    <div class="control">
                                        <input id="name" type="text" class="input @error('name') is-danger @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    </div>
                                    @error('name')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>
        
                                <div class="field">
                                    <label for="email" class="label">{{ __('Correo Electrónico') }}</label>
                                    <div class="control">
                                        <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    </div>
                                    @error('email')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>
        
                                <div class="field">
                                    <label for="password" class="label">{{ __('Contraseña') }}</label>
                                    <div class="control">
                                        <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="new-password">
                                    </div>
                                    @error('password')
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>
        
                                <div class="field">
                                    <label for="password-confirm" class="label">{{ __('Confirma la contraseña') }}</label>
                                    <div class="control">
                                        <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
        
                                <div class="field">
                                    <div class="control">
                                        <button type="submit" class="button is-primary">
                                            {{ __('Confirmar') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>