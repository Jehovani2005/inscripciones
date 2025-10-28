@extends('layouts.app')

@section('title', 'Registro de Participante')
@section('page-title', 'Registro de Participante')
@section('page-subtitle', 'Completa tus datos para inscribirte')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Información Personal</h2>
        
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Número de Trabajador -->
                <div>
                    <label for="numero_trabajador" class="form-label">Número de Trabajador *</label>
                    <input type="text" id="numero_trabajador" name="numero_trabajador" 
                           class="form-input" placeholder="Ej: UTS12345" required>
                </div>

                <!-- CURP -->
                <div>
                    <label for="curp" class="form-label">CURP *</label>
                    <input type="text" id="curp" name="curp" 
                           class="form-input" placeholder="Ej: ABC123456DEF789012" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nombre Completo -->
                <div>
                    <label for="nombre_completo" class="form-label">Nombre Completo *</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" 
                           class="form-input" placeholder="Ej: Juan Pérez García" required>
                </div>

                <!-- Fecha de Nacimiento -->
                <div>
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" 
                           class="form-input" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Antigüedad -->
                <div>
                    <label for="antiguedad" class="form-label">Antigüedad (años) *</label>
                    <input type="number" id="antiguedad" name="antiguedad" min="0" max="50"
                           class="form-input" placeholder="Ej: 3" required>
                </div>

                <!-- Fotografía -->
                <div>
                    <label for="fotografia" class="form-label">Fotografía del Rostro *</label>
                    <input type="file" id="fotografia" name="fotografia" 
                           class="form-input" accept="image/*" required>
                </div>
            </div>

            <!-- Documentos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Constancia Laboral -->
                <div>
                    <label for="constancia_laboral" class="form-label">Constancia Laboral *</label>
                    <input type="file" id="constancia_laboral" name="constancia_laboral" 
                           class="form-input" accept=".pdf,.jpg,.jpeg,.png" required>
                    <p class="text-xs text-gray-500 mt-1">Formatos: PDF, JPG, PNG (Máx. 5MB)</p>
                </div>

                <!-- CFDI/Recibo de Nómina -->
                <div>
                    <label for="comprobante_pago" class="form-label">CFDI/Recibo de Nómina *</label>
                    <input type="file" id="comprobante_pago" name="comprobante_pago" 
                           class="form-input" accept=".pdf,.jpg,.jpeg,.png" required>
                    <p class="text-xs text-gray-500 mt-1">Formatos: PDF, JPG, PNG (Máx. 5MB)</p>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4">
                <a href="{{ url('/') }}" class="btn bg-gray-300 text-gray-700 hover:bg-gray-400">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Guardar Registro
                </button>
            </div>
        </form>
    </div>

    <!-- Información importante -->
    <div class="card bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0 mt-1">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-semibold text-blue-800">Información Importante</h3>
                <ul class="mt-2 text-blue-700 list-disc list-inside space-y-1">
                    <li>Todos los campos marcados con * son obligatorios</li>
                    <li>Los documentos deben ser legibles y vigentes</li>
                    <li>Después del registro podrás seleccionar tus disciplinas</li>
                    <li>Recibirás una confirmación por correo electrónico</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection