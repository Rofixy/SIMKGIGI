@extends('layouts.app')

@section('content')
<style>
    .register-container {
        background: white;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .register-card {
        background: white;
        max-width: 400px;
        width: 100%;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .register-title {
        color: #333;
        font-weight: bold;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    
    .register-subtitle {
        color: #666;
        font-size: 1rem;
        margin-bottom: 2rem;
        text-align: center;
        line-height: 1.4;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 1rem;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }
    
    .btn-register {
        background: #007bff;
        border: none;
        border-radius: 5px;
        padding: 12px;
        font-weight: 600;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-register:hover {
        background: #0056b3;
    }
    
    .password-hint {
        color: #666;
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }
    
    .divider {
        height: 1px;
        background: #eee;
        margin: 1.5rem 0;
    }
    
    .login-link {
        text-align: center;
        margin-top: 1rem;
    }
    
    .login-link a {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
    }
    
    .footer {
        text-align: center;
        margin-top: 2rem;
        color: #666;
        font-size: 0.9rem;
    }
    
    .error-message {
        color: #dc3545;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
</style>

<div class="register-container">
    <div class="register-card">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="register-title">SIMKGIGI</h1>
            <p class="register-subtitle">Sistem Informasi<br>Manajemen Klinik<br>Gigi</p>
            <h3 style="color: #333; margin-top: 2rem;">Daftar Akun Baru</h3>
        </div>

        <!-- Form Body -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name Field -->
            <div class="form-group">
                <label for="name" class="form-label">{{ __('Nama Lengkap') }}</label>
                <input id="name" type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       autocomplete="name" 
                       autofocus
                       placeholder="Masukkan nama">
                @error('name')
                    <span class="error-message" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Alamat Email') }}</label>
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="email"
                       placeholder="contoh@email.com">
                @error('email')
                    <span class="error-message" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">{{ __('Kata Sandi') }}</label>
                <input id="password" type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" 
                       required 
                       autocomplete="new-password"
                       placeholder="Minimal 8 karakter">
                <p class="password-hint">
                    Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal
                </p>
                @error('password')
                    <span class="error-message" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="form-group">
                <label for="password-confirm" class="form-label">{{ __('Konfirmasi Kata Sandi') }}</label>
                <input id="password-confirm" type="password" 
                       class="form-control" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password"
                       placeholder="Ulangi kata sandi">
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn btn-register">
                {{ __('Register') }}
            </button>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Login Link -->
            <div class="login-link">
                <p class="mb-0">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}">Login</a>
                </p>
            </div>
        </form>

        <!-- Footer -->
        <div class="footer">
            © 2023 SIMKGIGI - Sistem Manajemen Klinik Gigi
        </div>
    </div>
</div>
@endsection