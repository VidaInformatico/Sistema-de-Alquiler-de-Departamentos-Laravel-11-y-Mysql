@extends('layouts.app')

@section('content')
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
                <div class="brand-logo text-center">
                    <img src="{{ asset('assets/admin/images/logo.png') }}">
                </div>
                <h6 class="font-weight-bold text-white">Inicia sesión para continuar.</h6>
                <form method="POST" action="{{ route('login') }}" class="pt-3">
                    @csrf

                    <div class="form-group">
                        <input type="email" class="form-control text-white form-control-lg @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            id="exampleInputEmail1" placeholder="Correo Electrónico">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control text-white form-control-lg @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" id="exampleInputPassword1"
                            placeholder="Contraseña">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <button type="submit"
                            class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                            INICIAR SESIÓN
                        </button>
                    </div>

                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input " name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}> Mantenme registrado
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link text-white">¿Has olvidado tu contraseña?</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection