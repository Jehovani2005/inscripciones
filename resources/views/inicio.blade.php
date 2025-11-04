@extends('layouts.base')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumen del sistema de inscripciones')

@section('content')
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
                <a href="{{ url('/reportes') }}" class="text-sm text-blue-600 font-medium">Ver todo</a>
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
                <a href="{{ url('/validaciones') }}" class="text-sm text-blue-600 font-medium">Ver todo</a>
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
            <a href="{{ url('/registro') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 mb-3">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-800 text-center">Nuevo Registro</span>
            </a>
            
            <a href="{{ url('/validaciones') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 transition-colors">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-green-600 mb-3">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-800 text-center">Validar Inscripciones</span>
            </a>
            
            <a href="{{ url('/reportes') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 transition-colors">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 mb-3">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-800 text-center">Generar Reporte</span>
            </a>
            
            <a href="{{ url('/configuracion') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-red-50 transition-colors">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center text-red-600 mb-3">
                    <i class="fas fa-cog text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-800 text-center">Configuración</span>
            </a>
        </div>
    </div>
@endsection