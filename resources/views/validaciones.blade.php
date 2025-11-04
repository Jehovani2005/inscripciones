@extends('layouts.base')

@section('title', 'Validación de Inscripciones')
@section('page-title', 'Validación de Inscripciones')
@section('page-subtitle', 'Revisa y valida los documentos de los participantes')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Filtros -->
    <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <h2 class="text-lg font-semibold text-gray-800">Filtros de Búsqueda</h2>
            
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <select class="form-input w-full sm:w-auto">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="rechazado">Rechazado</option>
                </select>
                
                <select class="form-input w-full sm:w-auto">
                    <option value="">Todas las disciplinas</option>
                    <option value="futbol">Fútbol</option>
                    <option value="basquetbol">Básquetbol</option>
                    <option value="voleibol">Voleibol</option>
                    <option value="ajedrez">Ajedrez</option>
                </select>
                
                <button class="btn btn-primary w-full sm:w-auto">
                    <i class="fas fa-filter mr-2"></i>Filtrar
                </button>
            </div>
        </div>
    </div>

    <!-- Lista de inscripciones pendientes -->
    <div class="card bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Inscripciones Pendientes de Validación</h2>
        
        <div class="space-y-6">
            <!-- Inscripción 1 -->
            <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 transition-colors">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <!-- Información del participante -->
                    <div class="flex items-start space-x-4 mb-4 lg:mb-0">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Juan Pérez García
                            </h3>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-id-card mr-1"></i>
                                    UTS12345
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-calendar mr-1"></i>
                                    3 años
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-running mr-1"></i>
                                    Fútbol 7 Varonil
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div class="flex space-x-2">
                        <button type="button" 
                                class="btn bg-green-600 text-white hover:bg-green-700 flex items-center ver-documentos">
                            <i class="fas fa-eye mr-2"></i>Ver Documentos
                        </button>
                    </div>
                </div>
                
                <!-- Documentos (oculto inicialmente) -->
                <div class="hidden mt-6 border-t pt-6 documentos-container">
                    <h4 class="text-md font-semibold text-gray-800 mb-4">Documentos del Participante</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Constancia Laboral -->
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="font-medium text-gray-800">Constancia Laboral</h5>
                                <a href="#" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" class="flex-1 btn bg-green-100 text-green-700 hover:bg-green-200 aprobar-doc">
                                    <i class="fas fa-check mr-1"></i> Aprobar
                                </button>
                                <button type="button" class="flex-1 btn bg-red-100 text-red-700 hover:bg-red-200 rechazar-doc">
                                    <i class="fas fa-times mr-1"></i> Rechazar
                                </button>
                            </div>
                        </div>
                        
                        <!-- Comprobante de Pago -->
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="font-medium text-gray-800">CFDI/Recibo de Nómina</h5>
                                <a href="#" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" class="flex-1 btn bg-green-100 text-green-700 hover:bg-green-200 aprobar-doc">
                                    <i class="fas fa-check mr-1"></i> Aprobar
                                </button>
                                <button type="button" class="flex-1 btn bg-red-100 text-red-700 hover:bg-red-200 rechazar-doc">
                                    <i class="fas fa-times mr-1"></i> Rechazar
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Validación final -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="font-semibold text-gray-800">Validación Final</h5>
                                <p class="text-sm text-gray-600">Aprueba o rechaza la inscripción completa</p>
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" class="btn bg-green-600 text-white hover:bg-green-700 aprobar-inscripcion">
                                    <i class="fas fa-check-circle mr-2"></i>Aprobar Inscripción
                                </button>
                                <button type="button" class="btn bg-red-600 text-white hover:bg-red-700 rechazar-inscripcion">
                                    <i class="fas fa-times-circle mr-2"></i>Rechazar Inscripción
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inscripción 2 -->
            <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 transition-colors">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-start space-x-4 mb-4 lg:mb-0">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                María García López
                            </h3>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-id-card mr-1"></i>
                                    UTS12346
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-calendar mr-1"></i>
                                    5 años
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-running mr-1"></i>
                                    Básquetbol Femenil
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button type="button" class="btn bg-green-600 text-white hover:bg-green-700 flex items-center ver-documentos">
                            <i class="fas fa-eye mr-2"></i>Ver Documentos
                        </button>
                    </div>
                </div>
                
                <div class="hidden mt-6 border-t pt-6 documentos-container">
                    <h4 class="text-md font-semibold text-gray-800 mb-4">Documentos del Participante</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="font-medium text-gray-800">Constancia Laboral</h5>
                                <a href="#" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" class="flex-1 btn bg-green-100 text-green-700 hover:bg-green-200 aprobar-doc">
                                    <i class="fas fa-check mr-1"></i> Aprobar
                                </button>
                                <button type="button" class="flex-1 btn bg-red-100 text-red-700 hover:bg-red-200 rechazar-doc">
                                    <i class="fas fa-times mr-1"></i> Rechazar
                                </button>
                            </div>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="font-medium text-gray-800">CFDI/Recibo de Nómina</h5>
                                <a href="#" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" class="flex-1 btn bg-green-100 text-green-700 hover:bg-green-200 aprobar-doc">
                                    <i class="fas fa-check mr-1"></i> Aprobar
                                </button>
                                <button type="button" class="flex-1 btn bg-red-100 text-red-700 hover:bg-red-200 rechazar-doc">
                                    <i class="fas fa-times mr-1"></i> Rechazar
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="font-semibold text-gray-800">Validación Final</h5>
                                <p class="text-sm text-gray-600">Aprueba o rechaza la inscripción completa</p>
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" class="btn bg-green-600 text-white hover:bg-green-700 aprobar-inscripcion">
                                    <i class="fas fa-check-circle mr-2"></i>Aprobar Inscripción
                                </button>
                                <button type="button" class="btn bg-red-600 text-white hover:bg-red-700 rechazar-inscripcion">
                                    <i class="fas fa-times-circle mr-2"></i>Rechazar Inscripción
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mostrar/ocultar documentos
    document.querySelectorAll('.ver-documentos').forEach(button => {
        button.addEventListener('click', function() {
            const documentosDiv = this.closest('.border').querySelector('.documentos-container');
            
            if (documentosDiv.classList.contains('hidden')) {
                documentosDiv.classList.remove('hidden');
                this.innerHTML = '<i class="fas fa-eye-slash mr-2"></i>Ocultar Documentos';
            } else {
                documentosDiv.classList.add('hidden');
                this.innerHTML = '<i class="fas fa-eye mr-2"></i>Ver Documentos';
            }
        });
    });

    // Aprobar documento individual
    document.querySelectorAll('.aprobar-doc').forEach(button => {
        button.addEventListener('click', function() {
            this.classList.remove('bg-green-100', 'text-green-700');
            this.classList.add('bg-green-500', 'text-white');
            this.innerHTML = '<i class="fas fa-check mr-1"></i> Aprobado';
            this.disabled = true;
            
            // Deshabilitar el botón de rechazar del mismo documento
            const rechazarBtn = this.parentElement.querySelector('.rechazar-doc');
            rechazarBtn.disabled = true;
            rechazarBtn.classList.remove('bg-red-100', 'text-red-700', 'hover:bg-red-200');
            rechazarBtn.classList.add('bg-gray-100', 'text-gray-400');
        });
    });

    // Rechazar documento individual
    document.querySelectorAll('.rechazar-doc').forEach(button => {
        button.addEventListener('click', function() {
            this.classList.remove('bg-red-100', 'text-red-700');
            this.classList.add('bg-red-500', 'text-white');
            this.innerHTML = '<i class="fas fa-times mr-1"></i> Rechazado';
            this.disabled = true;
            
            // Deshabilitar el botón de aprobar del mismo documento
            const aprobarBtn = this.parentElement.querySelector('.aprobar-doc');
            aprobarBtn.disabled = true;
            aprobarBtn.classList.remove('bg-green-100', 'text-green-700', 'hover:bg-green-200');
            aprobarBtn.classList.add('bg-gray-100', 'text-gray-400');
        });
    });

    // Aprobar inscripción completa
    document.querySelectorAll('.aprobar-inscripcion').forEach(button => {
        button.addEventListener('click', function() {
            const inscripcion = this.closest('.border');
            const nombre = inscripcion.querySelector('h3').textContent;
            
            if (confirm(`¿Estás seguro de aprobar la inscripción de ${nombre}?`)) {
                alert(`Inscripción de ${nombre} aprobada correctamente.`);
                inscripcion.style.display = 'none';
            }
        });
    });

    // Rechazar inscripción completa
    document.querySelectorAll('.rechazar-inscripcion').forEach(button => {
        button.addEventListener('click', function() {
            const inscripcion = this.closest('.border');
            const nombre = inscripcion.querySelector('h3').textContent;
            const motivo = prompt(`Ingresa el motivo de rechazo para ${nombre}:`);
            
            if (motivo) {
                alert(`Inscripción de ${nombre} rechazada.\nMotivo: ${motivo}`);
                inscripcion.style.display = 'none';
            }
        });
    });
</script>
@endsection