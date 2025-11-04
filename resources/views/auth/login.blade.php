<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inscripciones - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #dbeafe;
            --secondary: #0f766e;
            --accent: #dc2626;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --gray-border: #e2e8f0;
            --success: #059669;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 460px;
            background: white;
            border-radius: 12px;
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.05),
                0 10px 15px -3px rgba(0, 0, 0, 0.08),
                0 0 0 1px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            padding: 48px 40px;
            position: relative;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .logo-container {
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--gray-border);
        }

        .logo-container img {
            max-width: 300px;
            max-height: 140px;
            display: block;
            margin: 0 auto;
        }

        .brand-title {
            color: var(--dark);
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 8px;
        }

        .form-title {
            color: var(--gray);
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.025em;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            position: relative;
        }

        .form-group label {
            color: var(--dark);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .input-container {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--gray-border);
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s ease;
            background-color: white;
            color: var(--dark);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 16px;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray);
            transition: all 0.2s ease;
            font-size: 16px;
            background: none;
            border: none;
            padding: 4px;
            border-radius: 4px;
        }

        .toggle-password:hover {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        .error-message {
            color: var(--accent);
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .error-message i {
            font-size: 14px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 16px 0 8px;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember-me label {
            color: var(--gray);
            font-size: 14px;
            cursor: pointer;
            font-weight: 500;
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 8px;
            letter-spacing: 0.025em;
        }

        .login-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .register-button {
            width: 100%;
            padding: 14px;
            background-color: white;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 12px;
            letter-spacing: 0.025em;
        }

        .register-button:hover {
            background-color: var(--primary-light);
            transform: translateY(-1px);
        }

        .status-message {
            padding: 14px 16px;
            margin-bottom: 24px;
            border-radius: 8px;
            background-color: rgba(30, 64, 175, 0.05);
            color: var(--primary);
            text-align: center;
            font-size: 14px;
            border: 1px solid rgba(30, 64, 175, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .status-message.error {
            background-color: rgba(220, 38, 38, 0.05);
            color: var(--accent);
            border-color: rgba(220, 38, 38, 0.1);
        }

        .status-message.success {
            background-color: rgba(5, 150, 105, 0.05);
            color: var(--success);
            border-color: rgba(5, 150, 105, 0.1);
        }

        .security-notice {
            text-align: center;
            margin-top: 20px;
            padding: 12px;
            background-color: var(--gray-light);
            border-radius: 6px;
            font-size: 12px;
            color: var(--gray);
        }

        .security-notice i {
            color: var(--primary);
            margin-right: 6px;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 32px 24px;
                border-radius: 8px;
            }
            
            .brand-title {
                font-size: 22px;
            }
            
            .form-title {
                font-size: 14px;
            }

            .logo-container img {
                max-width: 240px;
            }

            .form-options {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
        }

        /* Animación sutil de entrada */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container {
            animation: fadeIn 0.4s ease-out;
        }

        /* Efecto de carga para el botón */
        .login-button.loading,
        .register-button.loading {
            pointer-events: none;
            position: relative;
            color: transparent;
        }

        .login-button.loading::after,
        .register-button.loading::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            top: 50%;
            left: 50%;
            margin-top: -9px;
            margin-left: -9px;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: button-loading-spinner 0.8s linear infinite;
        }

        .register-button.loading::after {
            border-top-color: var(--primary);
        }

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }

        /* Mejora de accesibilidad para focus */
        .login-button:focus,
        .register-button:focus,
        .forgot-password:focus,
        .toggle-password:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Session Status -->
        {{-- <div class="status-message" id="statusMessage"></div> --}}

        <div class="login-header">
            <div class="logo-container">
                <img src="{{asset('img/LOGO_UTS_PNG.png')}}" alt="Logo Universidad Tecnológica de la Selva" id="logo">
            </div>
            <h1 class="brand-title">SISTEMA DE INSCRIPCIONES</h1>
            <div class="form-title">INICIAR SESIÓN</div>
        </div>

        <!-- Formulario de Login -->
        <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <div class="input-container">
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="off" 
                        autocapitalize="off" 
                        spellcheck="false" 
                        placeholder="usuario@uts.edu.mx"
                    >
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                @if($errors->has('email'))
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-container">
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password" 
                        placeholder="Ingrese su contraseña"
                    >
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @if($errors->has('password'))
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="form-options">
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Mantener sesión activa</label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-password">
                    ¿Olvidó su contraseña?
                </a>
            </div>

            <button type="submit" class="login-button" id="loginButton">
                <span id="buttonText">INICIAR SESIÓN</span>
            </button>
        </form>


        <div class="login-form" style="text-align: center;">
            <a href="{{ route('register') }}" class="register-button" id="registerRedirect">
                <span id="registerButtonText">¿NO TIENES UNA CUENTA? REGÍSTRATE</span>
            </a>
        </div>


        <div class="security-notice">
            <i class="fas fa-shield-alt"></i>
            Sistema seguro - Sus datos están protegidos
        </div>
    </div>

    <script>
        // Función para mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.className = 'fas fa-eye';
            } else {
                icon.className = 'fas fa-eye-slash';
            }
        });

        // Manejo del envío del formulario de login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = document.getElementById('loginButton');
            const buttonText = document.getElementById('buttonText');
            
            // Mostrar estado de carga
            button.classList.add('loading');
            buttonText.textContent = 'VERIFICANDO...';
            
            // Permitir que el formulario se envíe normalmente
        });

        // Si hay errores después del envío, restaurar el botón
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const loginButton = document.getElementById('loginButton');
                const loginButtonText = document.getElementById('buttonText');
                
                if (loginButton) {
                    loginButton.classList.remove('loading');
                    loginButtonText.textContent = 'INICIAR SESIÓN';
                }
            });
        @endif

        // Enfocar el campo de email si está vacío
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (!emailInput.value) {
                emailInput.focus();
            }
        });
    </script>
</body>
</html>