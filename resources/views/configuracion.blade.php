@extends('layouts.app')

@section('title', 'Configuración del Sistema')
@section('page-title', 'Configuración del Sistema')
@section('page-subtitle', 'Configura los parámetros y opciones del sistema')

@section('content')
<div class="max-w-6xl mx-auto">
    <form action="#" method="POST">
        @csrf
        @method('PUT')

        <!-- Configuración General -->
        <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Configuración General</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Período de Inscripciones -->
                <div>
                    <label for="fecha_inicio_inscripciones" class="form-label">Fecha Inicio de Inscripciones *</label>
                    <input type="datetime-local" id="fecha_inicio_inscripciones" name="fecha_inicio_inscripciones" 
                           value="2024-01-15T08:00" class="form-input" required>
                </div>

                <div>
                    <label for="fecha_fin_inscripciones" class="form-label">Fecha Fin de Inscripciones *</label>
                    <input type="datetime-local" id="fecha_fin_inscripciones" name="fecha_fin_inscripciones" 
                           value="2024-02-15T23:59" class="form-input" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Cupo máximo por disciplina -->
                <div>
                    <label for="cupo_maximo_disciplina" class="form-label">Cupo Máximo por Disciplina *</label>
                    <input type="number" id="cupo_maximo_disciplina" name="cupo_maximo_disciplina" 
                           value="50" class="form-input" min="1" max="500" required>
                </div>

                <!-- Máximo de disciplinas por participante -->
                <div>
                    <label for="max_disciplinas_participante" class="form-label">Máximo Disciplinas por Participante *</label>
                    <input type="number" id="max_disciplinas_participante" name="max_disciplinas_participante" 
                           value="2" class="form-input" min="1" max="5" required>
                </div>
            </div>
        </div>

        <!-- Configuración de Notificaciones -->
        <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Configuración de Notificaciones</h2>
            
            <div class="space-y-4">
                <!-- Notificaciones por Email -->
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-800">Notificaciones por Email</h3>
                        <p class="text-sm text-gray-600">Enviar notificaciones vía correo electrónico</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="notificaciones_email" value="1" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <!-- Notificaciones por WhatsApp -->
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-800">Notificaciones por WhatsApp</h3>
                        <p class="text-sm text-gray-600">Enviar notificaciones vía WhatsApp</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="notificaciones_whatsapp" value="1" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                    </label>
                </div>

                <!-- Plantilla de Email -->
                <div>
                    <label for="plantilla_email" class="form-label">Plantilla de Email de Confirmación</label>
                    <textarea id="plantilla_email" name="plantilla_email" rows="4" 
                              class="form-input" placeholder="Plantilla para emails de confirmación...">Estimado participante,

Su inscripción ha sido recibida correctamente. Estará en proceso de validación y recibirá una notificación cuando sea aprobada.

Saludos cordiales,
Comité Organizador</textarea>
                </div>
            </div>
        </div>

        <!-- Configuración de Seguridad -->
        <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Configuración de Seguridad</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tiempo de sesión -->
                <div>
                    <label for="tiempo_sesion" class="form-label">Tiempo de Sesión (minutos) *</label>
                    <input type="number" id="tiempo_sesion" name="tiempo_sesion" 
                           value="120" class="form-input" min="15" max="1440" required>
                </div>

                <!-- Intentos de login -->
                <div>
                    <label for="intentos_login" class="form-label">Intentos de Login Permitidos *</label>
                    <input type="number" id="intentos_login" name="intentos_login" 
                           value="3" class="form-input" min="1" max="10" required>
                </div>
            </div>

            <div class="mt-6">
                <label class="flex items-center">
                    <input type="checkbox" name="requerir_verificacion_dos_pasos" value="1"
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Requerir verificación en dos pasos para administradores</span>
                </label>
            </div>
        </div>

        <!-- Configuración de Documentos -->
        <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Configuración de Documentos</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tamaño máximo de archivos -->
                <div>
                    <label for="tamano_maximo_archivo" class="form-label">Tamaño Máximo de Archivos (MB) *</label>
                    <input type="number" id="tamano_maximo_archivo" name="tamano_maximo_archivo" 
                           value="5" class="form-input" min="1" max="50" required>
                </div>

                <!-- Formatos permitidos -->
                <div>
                    <label for="formatos_permitidos" class="form-label">Formatos de Archivo Permitidos *</label>
                    <input type="text" id="formatos_permitidos" name="formatos_permitidos" 
                           value="pdf,jpg,jpeg,png" class="form-input" placeholder="pdf,jpg,jpeg,png" required>
                    <p class="text-xs text-gray-500 mt-1">Separar con comas</p>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4">
            <button type="reset" class="btn bg-gray-300 text-gray-700 hover:bg-gray-400">
                <i class="fas fa-redo mr-2"></i>Restablecer
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-2"></i>Guardar Configuración
            </button>
        </div>
    </form>

    <!-- Acciones Peligrosas -->
    <div class="card bg-white rounded-xl shadow-sm p-6 mt-6 border border-red-200">
        <h2 class="text-xl font-semibold text-red-800 mb-6">Zona de Peligro</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Limpiar datos de prueba -->
            <div class="p-4 border border-red-200 rounded-lg">
                <h3 class="font-medium text-red-800 mb-2">Limpiar Datos de Prueba</h3>
                <p class="text-sm text-red-600 mb-4">Elimina todos los registros de prueba del sistema</p>
                <button type="button" class="btn bg-red-600 text-white hover:bg-red-700 w-full limpiar-datos">
                    <i class="fas fa-broom mr-2"></i>Limpiar Datos
                </button>
            </div>

            <!-- Resetear configuraciones -->
            <div class="p-4 border border-red-200 rounded-lg">
                <h3 class="font-medium text-red-800 mb-2">Resetear Configuraciones</h3>
                <p class="text-sm text-red-600 mb-4">Restablece todas las configuraciones a valores por defecto</p>
                <button type="button" class="btn bg-red-600 text-white hover:bg-red-700 w-full resetear-config">
                    <i class="fas fa-undo mr-2"></i>Resetear Config
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Guardar configuración
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Configuración guardada correctamente (simulación)\n\nEn un sistema real, los cambios se guardarían en la base de datos.');
    });

    // Limpiar datos de prueba
    document.querySelector('.limpiar-datos').addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas eliminar todos los datos de prueba?\n\nEsta acción no se puede deshacer.')) {
            alert('Datos de prueba eliminados correctamente (simulación)');
        }
    });

    // Resetear configuraciones
    document.querySelector('.resetear-config').addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas restablecer todas las configuraciones a sus valores por defecto?')) {
            alert('Configuraciones restablecidas correctamente (simulación)');
            document.querySelector('form').reset();
        }
    });

    // Validación de fechas
    document.getElementById('fecha_inicio_inscripciones').addEventListener('change', function() {
        const fechaInicio = new Date(this.value);
        const fechaFin = new Date(document.getElementById('fecha_fin_inscripciones').value);
        
        if (fechaInicio >= fechaFin) {
            alert('La fecha de inicio debe ser anterior a la fecha de fin');
            this.value = '2024-01-15T08:00';
        }
    });

    document.getElementById('fecha_fin_inscripciones').addEventListener('change', function() {
        const fechaFin = new Date(this.value);
        const fechaInicio = new Date(document.getElementById('fecha_inicio_inscripciones').value);
        
        if (fechaFin <= fechaInicio) {
            alert('La fecha de fin debe ser posterior a la fecha de inicio');
            this.value = '2024-02-15T23:59';
        }
    });
</script>
@endsection