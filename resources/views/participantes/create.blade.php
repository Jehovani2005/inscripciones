@extends('layouts.base')

@section('title', 'Registro de Participante')
@section('page-title', 'Registro de Participante')
@section('page-subtitle', 'Completa tus datos para inscribirte')

@section('content')
    <div class="max-w-4xl mx-auto">

        @php
            $registro = DB::table('participantes')
                ->where('user_id', Auth::user()->id)
                ->whereNull('deleted_at')
                ->first();
        @endphp

        @if ($registro)
            {{-- Estado de ya registrado mejorado --}}
            <div class="card bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl shadow-sm p-8 text-center border border-green-200">
                <div class="w-20 h-20 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">¡Registro Completado!</h3>
                <p class="text-gray-600 max-w-md mx-auto mb-2">
                    Ya has completado tu registro exitosamente. Ahora puedes seleccionar las disciplinas en las que deseas participar.
                </p>
                <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('disciplinas.index') }}" class="btn bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 inline-flex items-center">
                        <i class="fas fa-running mr-2"></i>
                        Ver Disciplinas Disponibles
                    </a>
                    {{-- <a href="{{ url('/') }}" class="btn bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg transition-colors duration-200 inline-flex items-center">
                        <i class="fas fa-home mr-2"></i>
                        Ir al Inicio
                    </a> --}}
                </div>
            </div>

            {{-- Información adicional --}}
            {{-- <div class="card bg-blue-50 border border-blue-200 rounded-2xl p-6 mt-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-blue-500"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">¿Necesitas ayuda?</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-700">
                            <div class="flex items-start">
                                <i class="fas fa-phone-alt mt-1 mr-3 text-sm flex-shrink-0"></i>
                                <div>
                                    <p class="font-medium">Soporte Técnico</p>
                                    <p class="text-sm">Contacta al área correspondiente</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-envelope mt-1 mr-3 text-sm flex-shrink-0"></i>
                                <div>
                                    <p class="font-medium">Correo Electrónico</p>
                                    <p class="text-sm">soporte@sistema.edu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        @else
            {{-- Header del formulario --}}
            <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-sm p-6 mb-8 border border-blue-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-edit text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Completa tu Registro</h2>
                        <p class="text-sm text-gray-600 mt-1">Proporciona tu información personal y documentos requeridos para participar</p>
                    </div>
                </div>
            </div>

            {{-- Alertas mejoradas --}}
            @if (session('success'))
                <div class="card bg-green-50 border border-green-200 rounded-2xl p-4 mb-6 animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-green-800">¡Éxito!</h3>
                            <p class="text-green-700 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="card bg-red-50 border border-red-200 rounded-2xl p-4 mb-6 animate-fade-in">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-0.5">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800">Error en el formulario</h3>
                            <ul class="text-red-700 mt-2 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start">
                                        <i class="fas fa-chevron-right mt-1 mr-2 text-xs flex-shrink-0"></i>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Formulario principal --}}
            <div class="card bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100">
                <form action="{{ route('participantes.store') }}" method="POST" enctype="multipart/form-data" id="registroForm">
                    @csrf

                    {{-- Información básica --}}
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-id-card text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Información Personal</h3>
                                <p class="text-sm text-gray-500">Datos básicos de identificación</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="numero_trabajador" class="block text-sm font-medium text-gray-700 mb-2">
                                    Número de Trabajador *
                                </label>
                                <input type="text" id="numero_trabajador" name="numero_trabajador" 
                                    class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" 
                                    placeholder="Ej: UTS12345" required value="{{ old('numero_trabajador') }}">
                            </div>

                            <div>
                                <label for="curp" class="block text-sm font-medium text-gray-700 mb-2">
                                    CURP *
                                </label>
                                <input type="text" id="curp" name="curp" 
                                    class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200 uppercase" 
                                    placeholder="Ej: ABC123456DEF789012" required value="{{ old('curp') }}"
                                    maxlength="18" minlength="18">
                            </div>
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nombre_completo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre Completo *
                                </label>
                                <input type="text" id="nombre_completo" name="nombre_completo" 
                                    class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" 
                                    placeholder="Ej: Juan Pérez García" required value="{{ old('nombre_completo') }}">
                            </div>

                            <div>
                                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha de Nacimiento *
                                </label>
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" 
                                    class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" 
                                    required value="{{ old('fecha_nacimiento') }}"
                                    max="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Antigüedad y fotografía --}}
                    <div class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="antiguedad" class="block text-sm font-medium text-gray-700 mb-2">
                                    Antigüedad (años) *
                                </label>
                                <input type="number" id="antiguedad" name="antiguedad" min="0" max="50"
                                    class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" 
                                    placeholder="Ej: 3" required value="{{ old('antiguedad') }}">
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                    <span>Debe ser entre 0 y 50 años</span>
                                </div>
                            </div>

                            <div>
                                <label for="fotografia" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fotografía del Rostro *
                                </label>
                                <div class="relative">
                                    <input type="file" id="fotografia" name="fotografia" 
                                        class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                                        accept="image/*" required>
                                </div>
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <i class="fas fa-camera mr-2 text-blue-500"></i>
                                    <span>Formatos: JPG, JPEG, PNG (Máx. 5MB)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Documentos --}}
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-file-alt text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Documentos Requeridos</h3>
                                <p class="text-sm text-gray-500">Adjunta los documentos solicitados</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="constancia_laboral" class="block text-sm font-medium text-gray-700 mb-2">
                                    Constancia Laboral *
                                </label>
                                <div class="relative">
                                    <input type="file" id="constancia_laboral" name="constancia_laboral" 
                                        class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" 
                                        accept=".pdf,.jpg,.jpeg,.png" required>
                                </div>
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <i class="fas fa-file-pdf mr-2 text-purple-500"></i>
                                    <span>Formatos: PDF, JPG, PNG (Máx. 5MB)</span>
                                </div>
                            </div>

                            <div>
                                <label for="comprobante_pago" class="block text-sm font-medium text-gray-700 mb-2">
                                    CFDI/Recibo de Nómina *
                                </label>
                                <div class="relative">
                                    <input type="file" id="comprobante_pago" name="comprobante_pago" 
                                        class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" 
                                        accept=".pdf,.jpg,.jpeg,.png" required>
                                </div>
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <i class="fas fa-receipt mr-2 text-green-500"></i>
                                    <span>Formatos: PDF, JPG, PNG (Máx. 5MB)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center pt-6 border-t border-gray-200">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-shield-alt mr-2 text-blue-500"></i>
                                Tus datos están protegidos y serán usados únicamente para fines de registro
                            </p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ url('/') }}" class="btn bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg transition-colors duration-200 flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition-colors duration-200 flex items-center" id="submitBtn">
                                <i class="fas fa-save mr-2"></i>
                                <span>Guardar Registro</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Información importante mejorada --}}
            <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-sm p-6 border border-blue-100">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-blue-500"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-blue-800 mb-3">Información Importante</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-700">
                            <div class="flex items-start">
                                <i class="fas fa-asterisk mt-1 mr-3 text-xs text-blue-500 flex-shrink-0"></i>
                                <div>
                                    <p class="font-medium">Campos Obligatorios</p>
                                    <p class="text-sm">Todos los campos marcados con * son requeridos</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-file-check mt-1 mr-3 text-blue-500 flex-shrink-0"></i>
                                <div>
                                    <p class="font-medium">Documentos Legibles</p>
                                    <p class="text-sm">Asegúrate de que los documentos sean claros y vigentes</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-running mt-1 mr-3 text-blue-500 flex-shrink-0"></i>
                                <div>
                                    <p class="font-medium">Selección de Disciplinas</p>
                                    <p class="text-sm">Podrás elegir tus disciplinas después del registro</p>
                                </div>
                            </div>
                            {{-- <div class="flex items-start">
                                <i class="fas fa-envelope mt-1 mr-3 text-blue-500 flex-shrink-0"></i>
                                <div>
                                    <p class="font-medium">Confirmación</p>
                                    <p class="text-sm">Recibirás una confirmación por correo electrónico</p>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registroForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        form.addEventListener('submit', function() {
            // Mostrar estado de carga
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Procesando...';
        });
    }

    // Validación de CURP en tiempo real
    const curpInput = document.getElementById('curp');
    if (curpInput) {
        curpInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }

    // Validación de fecha de nacimiento
    const fechaInput = document.getElementById('fecha_nacimiento');
    if (fechaInput) {
        const today = new Date().toISOString().split('T')[0];
        fechaInput.setAttribute('max', today);
    }

    // Preview de archivos seleccionados
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Ningún archivo seleccionado';
            const label = this.parentElement.querySelector('.file-name') || 
                         document.createElement('span');
            
            if (!this.parentElement.querySelector('.file-name')) {
                label.className = 'file-name text-sm text-gray-500 mt-1 block';
                this.parentElement.appendChild(label);
            }
            
            label.textContent = `Archivo: ${fileName}`;
        });
    });
});
</script>

<style>
.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.uppercase {
    text-transform: uppercase;
}

.transition-colors {
    transition: all 0.2s ease-in-out;
}

.file\:bg-blue-50::file-selector-button {
    background-color: #eff6ff;
}

.file\:bg-purple-50::file-selector-button {
    background-color: #faf5ff;
}

.file\:bg-green-50::file-selector-button {
    background-color: #f0fdf4;
}
</style>
@endpush