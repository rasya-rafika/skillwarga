<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Register</title>
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 30%, #ddd6fe 70%, #c4b5fd 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-wrapper {
            width: 100%;
            max-width: 950px;
            margin: 0 auto;
        }

        .register-container {
            display: flex;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            width: 100%;
            min-height: 600px;
        }

        .welcome-section {
            flex: 1;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 30%, #a855f7 70%, #c084fc 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 40px;
            color: white;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 120%;
            height: 120%;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            transform: rotate(-15deg);
        }

        .welcome-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -20%;
            width: 80%;
            height: 80%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            z-index: 2;
            position: relative;
            font-size: 28px;
        }

        .welcome-title {
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 15px;
            z-index: 2;
            position: relative;
        }

        .welcome-subtitle {
            font-size: 16px;
            opacity: 0.9;
            z-index: 2;
            position: relative;
        }

        .register-section {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-height: 100vh;
            overflow-y: auto;
        }

        .register-header {
            margin-bottom: 30px;
        }

        .register-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .register-subtitle {
            color: #64748b;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            color: #374151;
            font-weight: 600;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .register-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.2);
            margin-top: 10px;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
            background: linear-gradient(135deg, #5b21b6 0%, #7c3aed 100%);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .register-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .login-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e1e5e9;
        }

        .login-text {
            color: #64748b;
            font-size: 14px;
        }

        .login-link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link:hover {
            text-decoration: underline;
            color: #5b21b6;
        }

        .status-message {
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
            border: 1px solid #c7d2fe;
            color: #3730a3;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            backdrop-filter: blur(10px);
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-col {
            flex: 1;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                max-width: 400px;
                margin: 20px auto;
            }

            .welcome-section {
                padding: 40px 30px;
                text-align: center;
                align-items: center;
            }

            .welcome-title {
                font-size: 32px;
            }

            .register-section {
                padding: 40px 30px;
            }

            .register-title {
                font-size: 24px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .welcome-section {
                padding: 30px 20px;
            }

            .register-section {
                padding: 30px 20px;
            }

            .welcome-title {
                font-size: 28px;
            }

            .register-title {
                font-size: 22px;
            }
        }

        /* Animation */
        .register-container {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-input, .register-button {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .floating-shapes {
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
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 15%;
            animation-delay: -2s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 20%;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="floating-shapes">
                    <div class="shape"></div>
                    <div class="shape"></div>
                    <div class="shape"></div>
                </div>
                <div class="logo">🚀</div>
                <h1 class="welcome-title">Bergabung<br>Bersama Kami!</h1>
                <p class="welcome-subtitle">Buat akun baru dan mulai perjalanan Anda di Skill Warga</p>
            </div>

            <!-- Register Form Section -->
            <div class="register-section">
                <div class="register-header">
                    <h2 class="register-title">Daftar Akun</h2>
                    <p class="register-subtitle">Isi form di bawah untuk membuat akun baru</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label class="form-label" for="name">{{ __('Name') }}</label>
                        <input 
                            class="form-input {{ $errors->get('name') ? 'error' : '' }}" 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            placeholder="Masukkan nama lengkap Anda"
                            required 
                            autofocus 
                            autocomplete="name"
                        />
                        @if ($errors->get('name'))
                            <div class="error-message">
                                @foreach ($errors->get('name') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label class="form-label" for="email">{{ __('Email') }}</label>
                        <input 
                            class="form-input {{ $errors->get('email') ? 'error' : '' }}" 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="username@gmail.com"
                            required 
                            autocomplete="username"
                        />
                        @if ($errors->get('email'))
                            <div class="error-message">
                                @foreach ($errors->get('email') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Password Fields Row -->
                    <div class="form-row">
                        <!-- Password -->
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                <input 
                                    class="form-input {{ $errors->get('password') ? 'error' : '' }}" 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    placeholder="••••••••"
                                    required 
                                    autocomplete="new-password"
                                />
                                @if ($errors->get('password'))
                                    <div class="error-message">
                                        @foreach ($errors->get('password') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <input 
                                    class="form-input {{ $errors->get('password_confirmation') ? 'error' : '' }}" 
                                    id="password_confirmation" 
                                    type="password" 
                                    name="password_confirmation" 
                                    placeholder="••••••••"
                                    required 
                                    autocomplete="new-password"
                                />
                                @if ($errors->get('password_confirmation'))
                                    <div class="error-message">
                                        @foreach ($errors->get('password_confirmation') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <button class="register-button" type="submit">
                        {{ __('Register') }}
                    </button>

                    <!-- Login Link -->
                    <div class="login-section">
                        <p class="login-text">
                            Sudah punya akun? 
                            <a class="login-link" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>