@extends('layouts.base')

@section('title', 'Reportes y Estadísticas')
@section('page-title', 'Reportes y Estadísticas')
@section('page-subtitle', 'Genera reportes de inscripciones y participación')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Filtros para reportes -->
    <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Generar Reporte</h2>
        
        <form id="form-reportes" action="#" method="GET" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tipo de Reporte -->
                <div>
                    <label for="tipo_reporte" class="form-label">Tipo de Reporte *</label>
                    <select id="tipo_reporte" name="tipo_reporte" class="form-input" required>
                        <option value="">Selecciona un tipo</option>
                        <option value="inscritos_por_disciplina">Inscritos por Disciplina</option>
                        <option value="validaciones_pendientes">Validaciones Pendientes</option>
                        <option value="participantes_aprobados">Participantes Aprobados</option>
                        <option value="estadisticas_generales">Estadísticas Generales</option>
                        <option value="lista_completa">Lista Completa de Inscritos</option>
                    </select>
                </div>

                <!-- Fecha Inicio -->
                <div>
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-input">
                </div>

                <!-- Fecha Fin -->
                <div>
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Formato -->
                <div>
                    <label for="formato" class="form-label">Formato de Salida *</label>
                    <select id="formato" name="formato" class="form-input" required>
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                        <option value="csv">CSV</option>
                    </select>
                </div>

                <!-- Disciplina (si aplica) -->
                <div>
                    <label for="disciplina_id" class="form-label">Filtrar por Disciplina</label>
                    <select id="disciplina_id" name="disciplina_id" class="form-input">
                        <option value="">Todas las disciplinas</option>
                        <option value="futbol">Fútbol</option>
                        <option value="basquetbol">Básquetbol</option>
                        <option value="voleibol">Voleibol</option>
                        <option value="ajedrez">Ajedrez</option>
                        <option value="atletismo">Atletismo</option>
                    </select>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-4">
                <button type="reset" class="btn bg-gray-300 text-gray-700 hover:bg-gray-400">
                    <i class="fas fa-redo mr-2"></i>Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-download mr-2"></i>Generar Reporte
                </button>
            </div>
        </form>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Inscritos</p>
                    <h3 class="text-2xl font-bold text-gray-800">1,248</h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Aprobados</p>
                    <h3 class="text-2xl font-bold text-gray-800">892</h3>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pendientes</p>
                    <h3 class="text-2xl font-bold text-gray-800">156</h3>
                </div>
                <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Disciplinas Activas</p>
                    <h3 class="text-2xl font-bold text-gray-800">12</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <i class="fas fa-running text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y tablas -->
    {{-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Inscritos por disciplina -->
        <div class="card bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Inscritos por Disciplina</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-blue-500 mr-3"></div>
                        <span class="text-gray-700">Fútbol 7 Varonil</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-800 font-medium">324</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                        <span class="text-gray-700">Básquetbol Varonil</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-800 font-medium">278</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 56%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-3"></div>
                        <span class="text-gray-700">Voleibol Femenil</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-800 font-medium">195</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-600 h-2 rounded-full" style="width: 39%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-purple-500 mr-3"></div>
                        <span class="text-gray-700">Ajedrez</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-800 font-medium">132</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 26%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-red-500 mr-3"></div>
                        <span class="text-gray-700">Atletismo</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-800 font-medium">98</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-red-600 h-2 rounded-full" style="width: 20%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estado de inscripciones -->
        <div class="card bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Estado de Inscripciones</h3>
            <div class="flex items-center justify-center mb-4">
                <div class="relative w-48 h-48">
                    <!-- Gráfico circular simulado -->
                    <div class="absolute inset-0 rounded-full border-8 border-green-500" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-yellow-500" style="clip-path: polygon(50% 50%, 100% 0, 100% 100%, 50% 50%); transform: rotate(72deg);"></div>
                    <div class="absolute inset-0 rounded-full border-8 border-red-500" style="clip-path: polygon(50% 50%, 100% 100%, 0 100%, 50% 50%); transform: rotate(216deg);"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-800">100%</div>
                            <div class="text-sm text-gray-600">Total</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                        <span class="text-sm text-gray-600">Aprobados</span>
                    </div>
                    <span class="text-sm font-medium text-gray-800">892 (71%)</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                        <span class="text-sm text-gray-600">Pendientes</span>
                    </div>
                    <span class="text-sm font-medium text-gray-800">156 (13%)</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                        <span class="text-sm text-gray-600">Rechazados</span>
                    </div>
                    <span class="text-sm font-medium text-gray-800">200 (16%)</span>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Reportes predefinidos -->
    {{-- <div class="card bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Reportes Predefinidos</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition-colors">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                    <i class="fas fa-list"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Lista Completa</p>
                    <p class="text-sm text-gray-600">Todos los inscritos</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-yellow-50 transition-colors">
                <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600 mr-4">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Pendientes</p>
                    <p class="text-sm text-gray-600">Por validar</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 transition-colors">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 mr-4">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Aprobados</p>
                    <p class="text-sm text-gray-600">Lista final</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 transition-colors">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 mr-4">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Estadísticas</p>
                    <p class="text-sm text-gray-600">Gráficas y datos</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-red-50 transition-colors">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 mr-4">
                    <i class="fas fa-file-excel"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Excel</p>
                    <p class="text-sm text-gray-600">Datos exportables</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-teal-50 transition-colors">
                <div class="w-10 h-10 rounded-lg bg-teal-100 flex items-center justify-center text-teal-600 mr-4">
                    <i class="fas fa-print"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Imprimir</p>
                    <p class="text-sm text-gray-600">Versión impresa</p>
                </div>
            </a>
        </div>
    </div> --}}
</div>

<script>
    // Simular generación de reporte
    document.querySelector('#form-reportes').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const tipoReporte = document.getElementById('tipo_reporte').value;
        const formato = document.getElementById('formato').value;
        
        if (!tipoReporte) {
            alert('Por favor selecciona un tipo de reporte');
            return;
        }
        
        alert(`Generando reporte: ${tipoReporte}\nFormato: ${formato.toUpperCase()}\n\nEsta es una demostración. En un sistema real se descargaría el archivo.`);
    });

    // Reportes predefinidos
    document.querySelectorAll('.grid a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const tipo = this.querySelector('p.font-medium').textContent;
            alert(`Generando reporte: ${tipo}\n\nEsta es una demostración. En un sistema real se descargaría el archivo.`);
        });
    });
</script>
@endsection