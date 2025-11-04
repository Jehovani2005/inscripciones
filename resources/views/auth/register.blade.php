<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema de Inscripciones - UTS</title>
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

        .register-container {
            width: 100%;
            max-width: 500px;
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

        .register-header {
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

        .register-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
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

        .register-button {
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

        .register-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .back-to-login {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 16px;
            transition: all 0.2s ease;
        }

        .back-to-login:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .password-requirements {
            margin-top: 8px;
            padding: 12px;
            background-color: var(--gray-light);
            border-radius: 6px;
            font-size: 13px;
        }

        .password-requirements small {
            display: block;
            margin-bottom: 8px;
            color: var(--gray);
            font-weight: 600;
        }

        .password-requirements ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .password-requirements li {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
            font-size: 12px;
            color: var(--gray);
        }

        .password-requirements li.valid {
            color: var(--success);
        }

        .password-requirements li.valid i {
            color: var(--success);
        }

        .password-requirements li i {
            font-size: 12px;
            width: 14px;
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
            .register-container {
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

        .register-container {
            animation: fadeIn 0.4s ease-out;
        }

        /* Efecto de carga para el botón */
        .register-button.loading {
            pointer-events: none;
            position: relative;
            color: transparent;
        }

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

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }

        /* Mejora de accesibilidad para focus */
        .register-button:focus,
        .toggle-password:focus,
        .back-to-login:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="logo-container">
                <img src="{{asset('img/LOGO_UTS_PNG.png')}}" alt="Logo Universidad Tecnológica de la Selva" id="logo">
            </div>
            <h1 class="brand-title">SISTEMA DE INSCRIPCIONES</h1>
            <div class="form-title">REGISTRO DE NUEVO USUARIO</div>
        </div>

        <!-- Formulario de Registro -->
        <form method="POST" action="{{ route('register') }}" class="register-form" id="registerForm">
            @csrf

            <!-- Nombre Completo -->
            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <div class="input-container">
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                        autocomplete="name" 
                        placeholder="Ingrese su nombre completo"
                    >
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                @if($errors->has('name'))
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

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
                        autocomplete="email" 
                        placeholder="usuario@uts.edu.mx"
                    >
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                @if($errors->has('email'))
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        El correo electrónico ya está registrado.
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
                        autocomplete="new-password" 
                        placeholder="Cree una contraseña segura"
                    >
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <!-- Validaciones de contraseña -->
                <div class="password-requirements">
                    <small>La contraseña debe contener:</small>
                    <ul class="list-unstyled">
                        <li id="req-length"><i class="fas fa-times-circle"></i> Mínimo 8 caracteres</li>
                        <li id="req-uppercase"><i class="fas fa-times-circle"></i> 1 letra mayúscula</li>
                        <li id="req-lowercase"><i class="fas fa-times-circle"></i> 1 letra minúscula</li>
                        <li id="req-number"><i class="fas fa-times-circle"></i> 1 número</li>
                        <li id="req-special"><i class="fas fa-times-circle"></i> 1 carácter especial (@$!%*?&)</li>
                    </ul>
                </div>
                
                @if($errors->has('password'))
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <div class="input-container">
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password" 
                        placeholder="Repita su contraseña"
                    >
                    <button type="button" class="toggle-password" id="toggleConfirmPassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="error-message" id="passwordMatchError"></div>
            </div>

            <button type="submit" class="register-button" id="registerSubmitButton">
                <span id="registerSubmitText">REGISTRAR USUARIO</span>
            </button>

            <a href="{{ route('login') }}" class="back-to-login">
                <i class="fas fa-arrow-left"></i>
                Volver al inicio de sesión
            </a>
        </form>

        <div class="security-notice">
            <i class="fas fa-shield-alt"></i>
            Sistema seguro - Sus datos están protegidos
        </div>
    </div>

    <script>
        // Función para mostrar/ocultar contraseña
        function setupPasswordToggle(passwordInputId, toggleButtonId) {
            const toggleButton = document.getElementById(toggleButtonId);
            const passwordInput = document.getElementById(passwordInputId);
            
            if (toggleButton && passwordInput) {
                toggleButton.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    const icon = this.querySelector('i');
                    if (type === 'password') {
                        icon.className = 'fas fa-eye';
                    } else {
                        icon.className = 'fas fa-eye-slash';
                    }
                });
            }
        }

        // Configurar toggles de contraseña
        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle('password_confirmation', 'toggleConfirmPassword');

        // Validaciones de contraseña en tiempo real
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordMatchError = document.getElementById('passwordMatchError');

        if (passwordInput) {
            passwordInput.addEventListener('input', validatePassword);
        }

        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', validatePasswordMatch);
        }

        function validatePassword() {
            const password = passwordInput.value;
            
            // Validar longitud
            const lengthValid = password.length >= 8;
            updateRequirement('req-length', lengthValid);
            
            // Validar mayúscula
            const uppercaseValid = /[A-Z]/.test(password);
            updateRequirement('req-uppercase', uppercaseValid);
            
            // Validar minúscula
            const lowercaseValid = /[a-z]/.test(password);
            updateRequirement('req-lowercase', lowercaseValid);
            
            // Validar número
            const numberValid = /[0-9]/.test(password);
            updateRequirement('req-number', numberValid);
            
            // Validar carácter especial
            const specialValid = /[@$!%*?&]/.test(password);
            updateRequirement('req-special', specialValid);
        }

        function updateRequirement(elementId, isValid) {
            const element = document.getElementById(elementId);
            if (element) {
                const icon = element.querySelector('i');
                if (isValid) {
                    element.classList.add('valid');
                    icon.className = 'fas fa-check-circle';
                } else {
                    element.classList.remove('valid');
                    icon.className = 'fas fa-times-circle';
                }
            }
        }

        function validatePasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword && password !== confirmPassword) {
                passwordMatchError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden';
            } else {
                passwordMatchError.innerHTML = '';
            }
        }

        // Manejo del envío del formulario de registro
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            // Validar contraseña antes de enviar
            const lengthValid = password.length >= 8;
            const uppercaseValid = /[A-Z]/.test(password);
            const lowercaseValid = /[a-z]/.test(password);
            const numberValid = /[0-9]/.test(password);
            const specialValid = /[@$!%*?&]/.test(password);
            const passwordsMatch = password === confirmPassword;
            
            if (!(lengthValid && uppercaseValid && lowercaseValid && numberValid && specialValid && passwordsMatch)) {
                e.preventDefault();
                alert('Por favor, complete todos los requisitos de contraseña y asegúrese de que las contraseñas coincidan.');
                return;
            }
            
            const button = document.getElementById('registerSubmitButton');
            const buttonText = document.getElementById('registerSubmitText');
            
            // Mostrar estado de carga
            button.classList.add('loading');
            buttonText.textContent = 'REGISTRANDO...';
        });

        // Si hay errores después del envío, restaurar el botón
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const registerButton = document.getElementById('registerSubmitButton');
                const registerButtonText = document.getElementById('registerSubmitText');
                
                if (registerButton) {
                    registerButton.classList.remove('loading');
                    registerButtonText.textContent = 'REGISTRAR USUARIO';
                }
            });
        @endif

        // Enfocar el campo de nombre si está vacío
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            if (!nameInput.value) {
                nameInput.focus();
            }
        });
    </script>
</body>
</html>