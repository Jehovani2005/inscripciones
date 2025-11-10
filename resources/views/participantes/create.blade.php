@extends('layouts.base')

@section('title', 'Registro de Participante')
@section('page-title', 'Registro de Participante')
@section('page-subtitle', 'Completa tus datos para inscribirte')

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- ESTO ES PARA QUE APARESCA DE QUE YA NO PUEDE REGISTRARSE DOS VECES --}}
        @php
            $registro = DB::table('participantes')
                ->where('user_id', Auth::user()->id)
                ->whereNull('deleted_at')
                ->first();
        @endphp


        @if ($registro)


            <!-- Información importante si YA SE REGISTRO -->
            <div class="card bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-blue-800">Información Importante</h3>
                        <ul class="mt-2 text-blue-700 list-disc list-inside space-y-1">
                            <li>Ya te has registrado una vez, no puedes hacerlo dos veces.</li>
                            <li>Ya puedes seleccionar las disciplinas a las que quieras participar.</li>
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 p-3 rounded mb-4">
                        <ul class="text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h2 class="text-xl font-semibold text-gray-800 mb-6">Información Personal</h2>

                <form action="{{ route('participantes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="numero_trabajador" class="form-label">Número de Trabajador *</label>
                            <input type="text" id="numero_trabajador" name="numero_trabajador" class="form-input"
                                placeholder="Ej: UTS12345" required value="{{ old('numero_trabajador') }}">
                        </div>

                        <div>
                            <label for="curp" class="form-label">CURP *</label>
                            <input type="text" id="curp" name="curp" class="form-input"
                                placeholder="Ej: ABC123456DEF789012" required value="{{ old('curp') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="nombre_completo" class="form-label">Nombre Completo *</label>
                            <input type="text" id="nombre_completo" name="nombre_completo" class="form-input"
                                placeholder="Ej: Juan Pérez García" required value="{{ old('nombre_completo') }}">
                        </div>

                        <div>
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-input" required
                                value="{{ old('fecha_nacimiento') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="antiguedad" class="form-label">Antigüedad (años) *</label>
                            <input type="number" id="antiguedad" name="antiguedad" min="0" max="50"
                                class="form-input" placeholder="Ej: 3" required value="{{ old('antiguedad') }}">
                        </div>

                        <div>
                            <label for="fotografia" class="form-label">Fotografía del Rostro *</label>
                            <input type="file" id="fotografia" name="fotografia" class="form-input" accept="image/*"
                                required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="constancia_laboral" class="form-label">Constancia Laboral *</label>
                            <input type="file" id="constancia_laboral" name="constancia_laboral" class="form-input"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            <p class="text-xs text-gray-500 mt-1">Formatos: PDF, JPG, PNG (Máx. 5MB)</p>
                        </div>

                        <div>
                            <label for="comprobante_pago" class="form-label">CFDI/Recibo de Nómina *</label>
                            <input type="file" id="comprobante_pago" name="comprobante_pago" class="form-input"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            <p class="text-xs text-gray-500 mt-1">Formatos: PDF, JPG, PNG (Máx. 5MB)</p>
                        </div>
                    </div>

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

        @endif

    </div>
@endsection
