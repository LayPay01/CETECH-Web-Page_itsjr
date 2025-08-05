@extends('layouts.plantilla')

@section('content')
    <div class="container">
        <div class="columns is-centered is-vcentered">
            <div class="column is-half">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">{{ __('Cambia la contraseña') }}</p>
                    </header>

                    <div class="card-content">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="field">
                                <label for="name" class="label">{{ __('Contraseña actual') }}</label>
                                <div class="control">
                                    <input id="name" type="text" class="input @error('name') is-danger @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                                @error('name')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="email" class="label">{{ __('Contraseña nueva') }}</label>
                                <div class="control">
                                    <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                </div>
                                @error('email')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="password" class="label">{{ __('Confirma la nueva contraseña') }}</label>
                                <div class="control">
                                    <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="new-password">
                                </div>
                                @error('password')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
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
@endsection