@extends('layouts.app')

@section('content')
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-white text-left p-5">
                <div class="brand-logo text-center">
                    <img src="{{ asset('assets/admin/images/logo.png') }}">
                </div>
                <h6 class="font-weight-light text-white">Registrarse es fácil. Sólo se necesitan unos pocos pasos</h6>
                <form method="POST" action="{{ route('register') }}" class="pt-3">
                    @csrf

                    <div class="form-group">
                        <input id="name" type="text"
                            class="form-control text-white form-control-lg @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="email" type="email"
                            class="form-control text-white form-control-lg @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" placeholder="Correo Electrónico">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="password" type="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                            required autocomplete="new-password" placeholder="Contraseña">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control form-control-lg"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirmar Contraseña">
                    </div>

                    <div class="mt-3">
                        <button type="submit"
                            class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                            Registrarse
                        </button>
                    </div>

                    <div class="text-center mt-4 font-weight-light">
                        ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-primary">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection