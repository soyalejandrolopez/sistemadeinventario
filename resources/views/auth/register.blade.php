@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-gradient-primary text-white text-center py-3" style="background: linear-gradient(135deg, #3490dc 0%, #38c172 100%);">
                    <h3 class="font-weight-bold my-2">{{ __('Crear Cuenta') }}</h3>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus fa-3x text-primary mb-2"></i>
                        <p class="text-muted">Completa el formulario para crear tu cuenta</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input id="name" type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus 
                                    placeholder="{{ __('Nombre completo') }}">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email" 
                                    placeholder="{{ __('Correo electrónico') }}">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="new-password" 
                                    placeholder="{{ __('Contraseña') }}">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="text-muted">La contraseña debe tener al menos 8 caracteres</small>
                        </div>

                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input id="password-confirm" type="password" class="form-control border-start-0" 
                                    name="password_confirmation" required autocomplete="new-password" 
                                    placeholder="{{ __('Confirmar contraseña') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Acepto los <a href="#" class="text-decoration-none">términos y condiciones</a>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary py-2 fw-bold text-uppercase">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Registrarse') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3 bg-light">
                    <div class="small">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                            {{ __('Inicia sesión aquí') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3490dc 0%, #38c172 100%);
    }
    
    .input-group-text {
        border-radius: 0.25rem 0 0 0.25rem;
    }
    
    .input-group .form-control {
        border-radius: 0 0.25rem 0.25rem 0;
    }
    
    .btn-primary {
        background-color: #3490dc;
        border-color: #3490dc;
        border-radius: 2rem;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #2779bd;
        border-color: #2779bd;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
