<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inscripciones - Universidad Tecnológica de la Selva</title>
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
        
        .nav-link:hover, .nav-link.active {
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
                    <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold">
                        UTS
                    </div>
                    <div class="ml-3">
                        <h1 class="text-lg font-bold text-gray-800">Inscripciones</h1>
                        <p class="text-xs text-gray-500">UT Selva</p>
                    </div>
                </div>
            </div>
            
            <!-- Menú de navegación -->
            <nav class="mt-6">
                <div class="px-4 mb-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Principal</p>
                </div>
                
                <a href="#" class="nav-link flex items-center px-4 py-3 text-gray-700 active">
                    <i class="fas fa-home mr-3 text-blue-500"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="#" class="nav-link flex items-center px-4 py-3 text-gray-700">
                    <i class="fas fa-user-plus mr-3 text-green-500"></i>
                    <span>Registro</span>
                </a>
                
                <a href="#" class="nav-link flex items-center px-4 py-3 text-gray-700">
                    <i class="fas fa-running mr-3 text-purple-500"></i>
                    <span>Disciplinas</span>
                </a>
                
                <a href="#" class="nav-link flex items-center px-4 py-3 text-gray-700">
                    <i class="fas fa-file-upload mr-3 text-yellow-500"></i>
                    <span>Documentos</span>
                </a>
                
                <div class="px-4 my-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Administración</p>
                </div>
                
                <a href="#" class="nav-link flex items-center px-4 py-3 text-gray-700">
                    <i class="fas fa-users-cog mr-3 text-indigo-500"></i>
                    <span>Validaciones</span>
                </a>
                
                <a href="#" class="nav-link flex items-center px-4 py-3 text-gray-700">
                    <i class="fas fa-chart-bar mr-3 text-teal-500"></i>
                    <span>Reportes</span>
                </a>
                
                <a href="#" class="nav-link flex items-center px-4 py-3 text-gray-700">
                    <i class="fas fa-cog mr-3 text-gray-500"></i>
                    <span>Configuración</span>
                </a>
            </nav>
            
            <!-- Información de usuario -->
            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-800">Usuario</p>
                        <p class="text-xs text-gray-500">Administrador</p>
                    </div>
                </div>
            </div>
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
                            <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
                            <p class="text-sm text-gray-500">Sistema de Inscripciones Deportivas y Culturales</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="relative mr-4">
                            <div class="text-gray-500 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                            </div>
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">3</span>
                        </div>
                        
                        <div class="relative">
                            <button class="flex items-center text-gray-700 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="ml-2 hidden md:block">Mi Cuenta</span>
                                <i class="fas fa-chevron-down ml-1 text-gray-500"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Contenido de la página -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <!-- Tarjetas de estadísticas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Inscritos</p>
                                <h3 class="text-2xl font-bold text-gray-800">1,248</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm text-green-500">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>12% más que el mes pasado</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-100 text-green-600">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Validados</p>
                                <h3 class="text-2xl font-bold text-gray-800">892</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm text-green-500">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>8% más que el mes pasado</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Pendientes</p>
                                <h3 class="text-2xl font-bold text-gray-800">156</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm text-red-500">
                                <i class="fas fa-arrow-down mr-1"></i>
                                <span>5% menos que el mes pasado</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                                <i class="fas fa-running text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Disciplinas</p>
                                <h3 class="text-2xl font-bold text-gray-800">24</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-minus mr-1"></i>
                                <span>Sin cambios</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Gráficos y contenido adicional -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-gray-800">Inscripciones por Disciplina</h2>
                            <button class="text-sm text-blue-600 font-medium">Ver todo</button>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-3"></div>
                                    <span class="text-gray-700">Fútbol</span>
                                </div>
                                <div class="text-gray-800 font-medium">324</div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                                    <span class="text-gray-700">Básquetbol</span>
                                </div>
                                <div class="text-gray-800 font-medium">278</div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-yellow-500 mr-3"></div>
                                    <span class="text-gray-700">Voleibol</span>
                                </div>
                                <div class="text-gray-800 font-medium">195</div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-purple-500 mr-3"></div>
                                    <span class="text-gray-700">Ajedrez</span>
                                </div>
                                <div class="text-gray-800 font-medium">132</div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-red-500 mr-3"></div>
                                    <span class="text-gray-700">Atletismo</span>
                                </div>
                                <div class="text-gray-800 font-medium">98</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-gray-800">Actividad Reciente</h2>
                            <button class="text-sm text-blue-600 font-medium">Ver todo</button>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-user-plus text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-800">Nueva inscripción</p>
                                    <p class="text-xs text-gray-500">Juan Pérez se registró en Fútbol</p>
                                    <p class="text-xs text-gray-400 mt-1">Hace 10 minutos</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-800">Validación completada</p>
                                    <p class="text-xs text-gray-500">María García fue aceptada en Básquetbol</p>
                                    <p class="text-xs text-gray-400 mt-1">Hace 25 minutos</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                        <i class="fas fa-exclamation text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-800">Documento requerido</p>
                                    <p class="text-xs text-gray-500">Carlos López necesita subir su CFDI</p>
                                    <p class="text-xs text-gray-400 mt-1">Hace 1 hora</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones rápidas -->
                <div class="card bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-6">Acciones Rápidas</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="#" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 mb-3">
                                <i class="fas fa-user-plus text-xl"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-800 text-center">Nuevo Registro</span>
                        </a>
                        
                        <a href="#" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 transition-colors">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-green-600 mb-3">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-800 text-center">Validar Inscripciones</span>
                        </a>
                        
                        <a href="#" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 transition-colors">
                            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 mb-3">
                                <i class="fas fa-chart-bar text-xl"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-800 text-center">Generar Reporte</span>
                        </a>
                        
                        <a href="#" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-red-50 transition-colors">
                            <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center text-red-600 mb-3">
                                <i class="fas fa-cog text-xl"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-800 text-center">Configuración</span>
                        </a>
                    </div>
                </div>
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
                
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>