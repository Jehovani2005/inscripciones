@auth

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Sistema de Inscripciones')</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            :root {
                --primary: #1e40af;
                --secondary: #0f766e;
                --accent: #dc2626;
                --light: #f8fafc;
                --dark: #1e293b;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: #f1f5f9;
            }

            .sidebar {
                transition: all 0.3s ease;
            }

            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .btn-primary {
                background-color: var(--primary);
                transition: background-color 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #1e3a8a;
            }

            .btn-secondary {
                background-color: var(--secondary);
                transition: background-color 0.3s ease;
            }

            .btn-secondary:hover {
                background-color: #0f5c55;
            }

            .nav-link {
                transition: all 0.2s ease;
            }

            .nav-link:hover,
            .nav-link.active {
                background-color: rgba(30, 64, 175, 0.1);
                color: var(--primary);
                border-left: 4px solid var(--primary);
            }

            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                    position: fixed;
                    z-index: 50;
                    height: 100vh;
                }

                .sidebar.active {
                    transform: translateX(0);
                }

                .overlay {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: rgba(0, 0, 0, 0.5);
                    z-index: 40;
                }

                .overlay.active {
                    display: block;
                }
            }

            .form-input {
                @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors;
            }

            .form-label {
                @apply block text-sm font-medium text-gray-700 mb-2;
            }

            .btn {
                @apply px-4 py-2 rounded-lg font-medium transition-colors duration-200;
            }

            .btn-primary {
                @apply bg-blue-600 text-white hover:bg-blue-700;
            }

            .btn-secondary {
                @apply bg-teal-600 text-white hover:bg-teal-700;
            }
        </style>
    </head>

    <body class="bg-gray-50">
        <!-- Layout Principal -->
        <div class="flex h-screen">
            <!-- Overlay para móviles -->
            <div class="overlay" id="overlay"></div>

            <!-- Sidebar -->
            <div class="sidebar w-64 bg-white shadow-lg z-30">
                <!-- Logo y título -->
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <!-- Imagen del logo -->
                        <div class="w-10 h-10 flex items-center justify-center">
                            <img src="{{ asset('img/ARBOL_UTS.png') }}" alt="Logo UTS"
                                class="w-full h-full object-contain rounded-lg">
                        </div>
                        <div class="ml-3">
                            <h1 class="text-lg font-bold text-gray-800">Inscripciones</h1>
                            <p class="text-xs text-gray-500">UT Selva</p>
                        </div>
                    </div>
                </div>


                <!-- Menú de navegación -->
                <nav class="mt-6">

                    @if (Auth::check() && Auth::user()->rol === 'Participante')
                        <div class="px-4 mb-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Principal</p>
                        </div>

                        {{-- <a href="{{ url('/') }}" class="nav-link flex items-center px-4 py-3 text-gray-700 ">
                        <i class="fas fa-home mr-3 text-blue-500"></i>
                        <span>Dashboard</span>
                    </a> --}}

                        <a href="{{ route('participantes.create') }}"
                            class="nav-link flex items-center px-4 py-3 text-gray-700 ">
                            <i class="fas fa-user-plus mr-3 text-green-500"></i>
                            <span>Registro</span>
                        </a>

                        <a href="{{ route('disciplinas.index') }}"
                            class="nav-link flex items-center px-4 py-3 text-gray-700 ">
                            <i class="fas fa-running mr-3 text-purple-500"></i>
                            <span>Disciplinas</span>
                        </a>

                        <a href="{{ url('/documentos') }}" class="nav-link flex items-center px-4 py-3 text-gray-700 ">
                            <i class="fas fa-file-upload mr-3 text-yellow-500"></i>
                            <span>Documentos</span>
                        </a>
                    @endif

                    @auth
                        {{-- Sección visible solo para Administrador --}}

                        @if (in_array(Auth::user()->rol, ['Administrador', 'Supervisor']))
                            <div class="px-4 my-4">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Administración</p>
                            </div>
                        @endif

                        @if (Auth::user()->rol === 'Administrador')
                            <a href="{{ url('/validaciones') }}" class="nav-link flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-users-cog mr-3 text-indigo-500"></i>
                                <span>Validaciones</span>
                            </a>

                            <a href="{{ url('/configuracion') }}" class="nav-link flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-cog mr-3 text-gray-500"></i>
                                <span>Configuración</span>
                            </a>
                        @endif

                        {{-- Sección visible tanto para Administrador como Supervisor --}}
                        @if (in_array(Auth::user()->rol, ['Administrador', 'Supervisor']))
                            <a href="{{ url('/reportes') }}" class="nav-link flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-chart-bar mr-3 text-teal-500"></i>
                                <span>Reportes</span>
                            </a>
                        @endif
                    @endauth

                </nav>

                <!-- Información de usuario -->
                {{-- <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-800">Usuario Demo</p>
                        <p class="text-xs text-gray-500">Administrador</p>
                    </div>
                </div>
            </div> --}}
            </div>

            <!-- Contenido Principal -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <header class="bg-white shadow-sm z-20">
                    <div class="flex items-center justify-between px-6 py-4">
                        <div class="flex items-center">
                            <button id="menu-toggle" class="text-gray-500 focus:outline-none lg:hidden">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <div class="ml-4 lg:ml-0">
                                <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                                <p class="text-sm text-gray-500">@yield('page-subtitle', 'Sistema de Inscripciones Deportivas y Culturales')</p>
                            </div>
                        </div>

                        <div class="flex items-center">

                            {{-- CAMPANA DE NOTIFICACIONES --}}

                            {{-- <div class="relative mr-4">
                            <div class="text-gray-500 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                            </div>
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">3</span>
                        </div> --}}

                            <div class="relative">
                                <input type="checkbox" id="user-menu-toggle" class="hidden">
                                <label for="user-menu-toggle" class="flex items-center text-gray-700 cursor-pointer">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span class="ml-2 md:block">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down ml-1 text-gray-500"></i>
                                </label>

                                <!-- Menú desplegable -->
                                <div
                                    class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden opacity-0 invisible transition-all duration-300 z-10 user-menu">
                                    <!-- Información del usuario -->
                                    <div class="p-4 border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                                <p class="text-xs text-gray-500">{{ Auth::user()->rol }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Opciones del menú -->
                                    <div class="py-1">
                                        <a href="#"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user-circle mr-3 text-gray-500"></i>
                                            Mi Perfil
                                        </a>
                                        <a href="#"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-cog mr-3 text-gray-500"></i>
                                            Configuración
                                        </a>
                                        <div class="border-t border-gray-100 my-1"></div>

                                        {{-- Botón de Cerrar Sesión --}}
                                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                <i class="fas fa-sign-out-alt mr-3"></i>
                                                <span>Cerrar Sesión</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .hidden {
                                    display: none;
                                }

                                #user-menu-toggle:checked~.user-menu {
                                    opacity: 1;
                                    visibility: visible;
                                }

                                #user-menu-toggle:checked+label .fa-chevron-down {
                                    transform: rotate(180deg);
                                }

                                .fa-chevron-down {
                                    transition: transform 0.3s ease;
                                }
                            </style>
                        </div>
                    </div>
                </header>

                <!-- Contenido de la página -->
                <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                    @yield('content')
                </main>
            </div>
        </div>

        <script>
            // Toggle del menú en dispositivos móviles
            document.getElementById('menu-toggle').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
                document.getElementById('overlay').classList.toggle('active');
            });

            document.getElementById('overlay').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.remove('active');
                this.classList.remove('active');
            });

            // Activar elementos del menú al hacer clic
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth < 768) {
                        document.querySelector('.sidebar').classList.remove('active');
                        document.getElementById('overlay').classList.remove('active');
                    }
                });
            });
        </script>
    </body>

    </html>

@endauth
