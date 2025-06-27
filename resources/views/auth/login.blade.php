@extends('layouts.app')

@section('content')
<div class="login-container">
    <!-- Background Elements -->
    <div class="login-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="floating-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Left Side - Branding/Welcome -->
            <div class="col-lg-6 d-none d-lg-flex login-brand-side">
                <div class="brand-content">
                    <div class="brand-logo mb-4">
                        <div class="logo-circle">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h2 class="brand-name">SIMKGIGI</h2>
                    </div>
                    
                    <div class="welcome-content">
                        <h1 class="welcome-title">Selamat Datang Kembali!</h1>
                        <p class="welcome-subtitle">Selamat Melakukan Kunjungan Lagi</p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center login-form-side">
                <div class="login-form-container">
                    <div class="text-center mb-4">
                        <div class="login-icon mb-3">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h3 class="login-title">Masuk ke Akun Anda</h3>
                        <p class="login-subtitle">Silakan masukkan kredensial Anda untuk melanjutkan</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
                        @csrf

                        <!-- Email Input -->
                        <div class="form-floating mb-3">
                            <input type="email" 
                                class="form-control modern-input @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                placeholder="name@example.com"
                                required 
                                autofocus>
                            <label for="email">
                                <i class="bi bi-envelope me-2"></i>Alamat Email
                            </label>
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" 
                                class="form-control modern-input @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Password"
                                required>
                            <label for="password">
                                <i class="bi bi-lock me-2"></i>Kata Sandi
                            </label>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check custom-checkbox">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                            
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn login-btn w-100 mb-3" id="loginButton">
                            <span class="btn-text">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Masuk
                            </span>
                            <span class="btn-loading d-none">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Memproses...
                            </span>
                        </button>

                    </form>

                    <!-- Register Link -->
                    <div class="text-center mt-4">
                        <p class="register-text">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="register-link">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password Toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });

    // Form Submit Loading
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');
    
    loginForm.addEventListener('submit', function() {
        const btnText = loginButton.querySelector('.btn-text');
        const btnLoading = loginButton.querySelector('.btn-loading');
        
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        loginButton.disabled = true;
    });

    // Input Focus Effects
    const inputs = document.querySelectorAll('.modern-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
});
</script>

<style>
:root {
    --primary-color: #6366f1;
    --primary-hover: #5855eb;
    --secondary-color: #f8fafc;
    --accent-color: #06b6d4;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --border-color: #e2e8f0;
    --error-color: #ef4444;
    --success-color: #22c55e;
    --shadow-light: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-medium: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

* {
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.login-container {
    position: relative;
    min-height: 100vh;
    overflow: hidden;
}

/* Background Shapes */
.login-bg-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: -150px;
    right: -150px;
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    bottom: -100px;
    left: -100px;
    animation-delay: 2s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-20px) scale(1.05); }
}

/* Floating Particles */
.floating-particles {
    position: absolute;
    width: 100%;
    height: 100%;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: particle-float 8s linear infinite;
}

.particle:nth-child(1) { left: 10%; animation-delay: 0s; }
.particle:nth-child(2) { left: 30%; animation-delay: 2s; }
.particle:nth-child(3) { left: 50%; animation-delay: 4s; }
.particle:nth-child(4) { left: 70%; animation-delay: 6s; }
.particle:nth-child(5) { left: 90%; animation-delay: 8s; }

@keyframes particle-float {
    0% { 
        transform: translateY(100vh) scale(0);
        opacity: 0;
    }
    10% {
        opacity: 1;
        transform: scale(1);
    }
    90% {
        opacity: 1;
    }
    100% { 
        transform: translateY(-100px) scale(0);
        opacity: 0;
    }
}

/* Brand Side */
.login-brand-side {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.9) 0%, rgba(139, 92, 246, 0.9) 100%);
    color: white;
    position: relative;
    z-index: 2;
}

.brand-content {
    padding: 4rem 3rem;
    max-width: 500px;
    margin: auto;
}

.brand-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.logo-circle {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.brand-name {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.welcome-title {
    font-size: 3rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-subtitle {
    font-size: 1.25rem;
    opacity: 0.9;
    margin-bottom: 3rem;
    line-height: 1.6;
}

.features-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.feature-item:hover {
    transform: translateX(10px);
    background: rgba(255, 255, 255, 0.15);
}

.feature-item i {
    font-size: 1.5rem;
    color: #fbbf24;
}

/* Form Side */
.login-form-side {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    position: relative;
    z-index: 2;
}

.login-form-container {
    width: 100%;
    max-width: 450px;
    padding: 2rem;
}

.login-icon {
    font-size: 4rem;
    color: var(--primary-color);
    opacity: 0.8;
}

.login-title {
    color: var(--text-primary);
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.login-subtitle {
    color: var(--text-secondary);
    font-size: 1rem;
    margin-bottom: 2rem;
}

/* Modern Form Inputs */
.form-floating {
    position: relative;
}

.modern-input {
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 1rem 1rem 1rem 3rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.modern-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    background: rgba(255, 255, 255, 0.95);
}

.form-floating.focused label {
    color: var(--primary-color);
}

.form-floating label {
    padding-left: 3rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.form-floating label i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.1rem;
}

/* Password Toggle */
.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-secondary);
    font-size: 1.1rem;
    cursor: pointer;
    z-index: 10;
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: var(--primary-color);
}

/* Custom Checkbox */
.custom-checkbox .form-check-input {
    border-radius: 6px;
    border: 2px solid var(--border-color);
    width: 1.2rem;
    height: 1.2rem;
}

.custom-checkbox .form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

/* Links */
.forgot-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.forgot-link:hover {
    color: var(--primary-hover);
    text-decoration: underline;
}

/* Login Button */
.login-btn {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
    border: none;
    border-radius: 12px;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.login-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.login-btn:hover::before {
    left: 100%;
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-large);
}

.login-btn:active {
    transform: translateY(0);
}

/* Divider */
.divider {
    position: relative;
    text-align: center;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    width: 45%;
    height: 1px;
    background: var(--border-color);
}

.divider::after {
    content: '';
    position: absolute;
    top: 50%;
    right: 0;
    width: 45%;
    height: 1px;
    background: var(--border-color);
}

.divider span {
    background: rgba(255, 255, 255, 0.95);
    padding: 0 1rem;
}

/* Social Login */
.social-login {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.social-btn {
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.8);
    color: var(--text-primary);
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.social-btn:hover {
    border-color: var(--primary-color);
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
}

.google-btn:hover {
    border-color: #ea4335;
    color: #ea4335;
}

.microsoft-btn:hover {
    border-color: #00a1f1;
    color: #00a1f1;
}

/* Register Link */
.register-text {
    color: var(--text-secondary);
    margin-bottom: 0;
}

.register-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.register-link:hover {
    color: var(--primary-hover);
    text-decoration: underline;
}

/* Error States */
.is-invalid {
    border-color: var(--error-color) !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

.invalid-feedback {
    display: block;
    font-size: 0.875rem;
    color: var(--error-color);
    margin-top: 0.5rem;
}

/* Responsive Design */
@media (max-width: 991.98px) {
    .login-form-container {
        padding: 1.5rem;
    }
    
    .welcome-title {
        font-size: 2.5rem;
    }
    
    .brand-content {
        padding: 3rem 2rem;
    }
}

@media (max-width: 767.98px) {
    .login-form-container {
        padding: 1rem;
    }
    
    .social-login {
        grid-template-columns: 1fr;
    }
    
    .login-title {
        font-size: 1.75rem;
    }
}

/* Loading Animation */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

.btn-loading {
    animation: pulse 1.5s ease-in-out infinite;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Focus Visible */
.login-btn:focus-visible,
.social-btn:focus-visible,
.modern-input:focus-visible {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}
</style>
@endsection