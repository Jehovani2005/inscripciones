@extends('layouts.base')

@section('title', 'Disciplinas Disponibles')
@section('page-title', 'Disciplinas Deportivas y Culturales')
@section('page-subtitle', 'Solicita tu participación en hasta 2 disciplinas')

@section('content')
<div class="max-w-7xl mx-auto">

    @if ($participante)
        {{-- Header de usuario mejorado --}}
        <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-sm p-6 mb-8 border border-blue-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">¡Hola, {{ Auth::user()->name }}!</h3>
                        <p class="text-gray-600 mt-1">Selecciona hasta <strong class="text-blue-600">2 disciplinas</strong> para participar.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                    <div class="text-center">
                        <p class="text-sm text-gray-500 mb-1">Solicitudes enviadas</p>
                        <div class="flex items-center justify-center space-x-2">
                            <span class="text-2xl font-bold text-blue-600" id="contador-disciplinas">0</span>
                            <span class="text-gray-400">/</span>
                            <span class="text-lg text-gray-600">2</span>
                        </div>
                        <div class="w-24 h-2 bg-gray-200 rounded-full mt-2 mx-auto">
                            <div id="progress-bar" class="h-2 bg-blue-500 rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alertas mejoradas --}}
        <div id="alert-container" class="mb-6"></div>

        {{-- Información de estado --}}
        <div class="card bg-white rounded-2xl shadow-sm p-5 mb-8 border border-gray-100">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Disponible</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Casi lleno</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Sin cupo</span>
                    </div>
                </div>
                
                <div class="text-sm text-gray-500 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    <span>Puedes modificar tus selecciones hasta que sean aprobadas</span>
                </div>
            </div>
        </div>

        {{-- Listado de ofertas mejorado --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="ofertas-container">
            @foreach ($ofertas as $oferta)
                @php
                    $ocupados = \App\Models\ParticipanteOferta::where('oferta_disciplina_id', $oferta->id)
                        ->where('estado', 'aprobada')
                        ->count();
                    $disponibles = max(0, $oferta->capacidad - $ocupados);
                    $porcentajeOcupacion = $oferta->capacidad > 0 ? round(($ocupados / $oferta->capacidad) * 100) : 0;
                    
                    $estadoCupo = $disponibles > 5 ? 'Disponible' : ($disponibles > 0 ? 'Casi lleno' : 'Lleno');
                    $estadoColor = $disponibles > 5 ? 'text-green-600' : ($disponibles > 0 ? 'text-yellow-600' : 'text-red-600');
                    $estadoBg = $disponibles > 5 ? 'bg-green-100' : ($disponibles > 0 ? 'bg-yellow-100' : 'bg-red-100');
                    $estadoBorder = $disponibles > 5 ? 'border-green-200' : ($disponibles > 0 ? 'border-yellow-200' : 'border-red-200');

                    // obtener solicitud si existe
                    $solicitud = \App\Models\ParticipanteOferta::where('participante_id', $participante->id)
                        ->where('oferta_disciplina_id', $oferta->id)
                        ->first();
                @endphp

                <div class="card bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-200 oferta-card transform hover:-translate-y-1" data-oferta-id="{{ $oferta->id }}">
                    {{-- Barra de estado de cupo --}}
                    <div class="h-1.5 w-full {{ $disponibles > 5 ? 'bg-green-500' : ($disponibles > 0 ? 'bg-yellow-500' : 'bg-red-500') }}"></div>
                    
                    <div class="p-5">
                        {{-- Header de la disciplina --}}
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h3 class="text-lg font-bold text-gray-800 truncate">{{ $oferta->disciplina->nombre }}</h3>
                                    <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $oferta->disciplina->tipo }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $oferta->disciplina->descripcion ?? 'Sin descripción disponible' }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-sm">
                                <i class="fas fa-medal text-xl"></i>
                            </div>
                        </div>

                        {{-- Barra de progreso de cupo --}}
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Cupos ocupados</span>
                                <span>{{ $porcentajeOcupacion }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $disponibles > 5 ? 'bg-green-500' : ($disponibles > 0 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                     style="width: {{ $porcentajeOcupacion }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1 text-right">
                                {{ $disponibles }} de {{ $oferta->capacidad }} disponibles
                            </div>
                        </div>

                        {{-- Información de fechas --}}
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                            <span>Inscripciones hasta: {{ \Carbon\Carbon::parse($oferta->fin_inscripcion)->format('d/m/Y') }}</span>
                        </div>

                        {{-- BOTONES SEGÚN ESTADO DE LA SOLICITUD --}}
                        @if ($solicitud)
                            @if ($solicitud->estado === 'pendiente')
                                <button type="button" class="w-full btn bg-yellow-100 text-yellow-800 border border-yellow-200 rounded-xl py-3 cursor-default flex items-center justify-center transition-colors duration-200">
                                    <i class="fas fa-hourglass-half mr-2"></i>
                                    <span>Solicitud Pendiente</span>
                                </button>
                            @elseif ($solicitud->estado === 'aprobada')
                                <button type="button" class="w-full btn bg-green-100 text-green-800 border border-green-200 rounded-xl py-3 cursor-default flex items-center justify-center transition-colors duration-200">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <span>Inscripción Aprobada</span>
                                </button>
                            @elseif ($solicitud->estado === 'rechazada')
                                <button type="button" class="w-full btn bg-red-100 text-red-800 border border-red-200 rounded-xl py-3 cursor-default flex items-center justify-center transition-colors duration-200">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    <span>Solicitud Rechazada</span>
                                </button>
                            @endif
                        @else
                            @if ($disponibles <= 0)
                                <button type="button" class="w-full btn bg-gray-100 text-gray-500 border border-gray-200 rounded-xl py-3 cursor-not-allowed flex items-center justify-center" disabled>
                                    <i class="fas fa-ban mr-2"></i>
                                    <span>Sin cupo disponible</span>
                                </button>
                            @else
                                <button type="button" class="w-full btn bg-blue-600 hover:bg-blue-700 text-white border border-blue-600 rounded-xl py-3 transition-all duration-200 flex items-center justify-center solicitar-btn transform hover:scale-105" data-oferta-id="{{ $oferta->id }}">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    <span>Solicitar Inscripción</span>
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Contenedor de solicitudes activas --}}
        {{-- <div class="card bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100" id="disciplinas-solicitadas-container" style="display:none;">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-clipboard-list text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Tus Solicitudes Activas</h3>
                    <p class="text-sm text-gray-500">Solicitudes pendientes de aprobación</p>
                </div>
            </div>
            <div id="disciplinas-solicitadas" class="space-y-3"></div>
        </div> --}}

    @else
        {{-- Estado de no registro mejorado --}}
        <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-sm p-8 text-center border border-blue-100">
            <div class="w-20 h-20 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-circle text-blue-500 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">Registro Incompleto</h3>
            <p class="text-gray-600 max-w-md mx-auto mb-6">
                Para participar en las disciplinas, primero debes completar tu registro y cargar los documentos requeridos.
            </p>
            <a href="{{ route('participantes.create') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 inline-flex items-center">
                <i class="fas fa-user-edit mr-2"></i>
                Completar Mi Registro
            </a>
        </div>
    @endif

</div>

{{-- Scripts mejorados --}}
<script>
(function(){
    const MAX = 2;
    const alertContainer = document.getElementById('alert-container');
    const contadorEl = document.getElementById('contador-disciplinas');
    const progressBar = document.getElementById('progress-bar');
    let solicitudes = @json($selecciones ?? []);

    function mostrarAlerta(tipo, mensaje, timeout = 5000) {
        const alertId = 'alert-' + Date.now();
        const alertClass = tipo === 'success' 
            ? 'bg-green-50 border border-green-200 text-green-700' 
            : tipo === 'error' 
            ? 'bg-red-50 border border-red-200 text-red-700'
            : 'bg-blue-50 border border-blue-200 text-blue-700';
            
        const icon = tipo === 'success' 
            ? 'fa-check-circle' 
            : tipo === 'error' 
            ? 'fa-exclamation-circle'
            : 'fa-info-circle';

        const alertHTML = `
            <div id="${alertId}" class="rounded-xl p-4 ${alertClass} flex items-start shadow-sm mb-3 animate-fade-in">
                <i class="fas ${icon} mt-0.5 mr-3 flex-shrink-0"></i>
                <div class="flex-1">
                    <p class="text-sm font-medium">${mensaje}</p>
                </div>
                <button onclick="document.getElementById('${alertId}').remove()" class="ml-4 text-gray-400 hover:text-gray-600 flex-shrink-0">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        alertContainer.insertAdjacentHTML('afterbegin', alertHTML);
        
        if (timeout) {
            setTimeout(() => {
                const alertElement = document.getElementById(alertId);
                if (alertElement) {
                    alertElement.style.opacity = '0';
                    alertElement.style.transform = 'translateX(100%)';
                    setTimeout(() => alertElement.remove(), 300);
                }
            }, timeout);
        }
    }

    function actualizarContador() {
        const count = solicitudes.length;
        contadorEl.textContent = count;
        const progressWidth = (count / MAX) * 100;
        progressBar.style.width = `${progressWidth}%`;
        
        // Cambiar color de la barra de progreso
        if (count === MAX) {
            progressBar.classList.remove('bg-blue-500', 'bg-yellow-500');
            progressBar.classList.add('bg-green-500');
        } else if (count > 0) {
            progressBar.classList.remove('bg-blue-500', 'bg-green-500');
            progressBar.classList.add('bg-yellow-500');
        } else {
            progressBar.classList.remove('bg-yellow-500', 'bg-green-500');
            progressBar.classList.add('bg-blue-500');
        }
    }

    async function solicitarInscripcion(ofertaId, btn) {
        if (solicitudes.length >= MAX) {
            mostrarAlerta('error', `❌ Ya has alcanzado el límite de ${MAX} disciplinas.`);
            return;
        }

        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `
            <div class="flex items-center justify-center">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                <span>Enviando solicitud...</span>
            </div>
        `;
        btn.classList.remove('hover:bg-blue-700', 'hover:scale-105');
        btn.classList.add('bg-blue-400');

        try {
            const resp = await fetch("{{ route('disciplinas.seleccionar') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ oferta_id: ofertaId })
            });

            const data = await resp.json();

            if (!resp.ok) {
                throw new Error(data.mensaje || 'Error al enviar solicitud');
            }

            // Éxito
            solicitudes.push(ofertaId);
            mostrarAlerta('success', '✅ ' + (data.mensaje || 'Solicitud enviada correctamente.'));
            
            // Actualizar UI de la tarjeta
            const card = btn.closest('.oferta-card');
            btn.outerHTML = `
                <button type="button" class="w-full btn bg-yellow-100 text-yellow-800 border border-yellow-200 rounded-xl py-3 cursor-default flex items-center justify-center transition-colors duration-200">
                    <i class="fas fa-hourglass-half mr-2"></i>
                    <span>Solicitud Pendiente</span>
                </button>
            `;
            
            actualizarContador();

        } catch (error) {
            console.error('Error:', error);
            mostrarAlerta('error', '❌ ' + error.message);
            
            // Restaurar botón
            btn.disabled = false;
            btn.innerHTML = originalContent;
            btn.classList.remove('bg-blue-400');
            btn.classList.add('hover:bg-blue-700', 'hover:scale-105');
        }
    }

    // Event listeners
    document.querySelectorAll('.solicitar-btn').forEach(btn => {
        btn.addEventListener('click', async function(){
            await solicitarInscripcion(this.dataset.ofertaId, this);
        });
    });

    // Inicializar
    actualizarContador();

    // Mostrar contenedor de solicitudes si hay alguna
    if (solicitudes.length > 0) {
        document.getElementById('disciplinas-solicitadas-container').style.display = 'block';
    }

})();
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.transition-all {
    transition: all 0.3s ease;
}

.transform {
    transform: translateX(0) translateY(0) rotate(0) skewX(0) skewY(0) scaleX(1) scaleY(1);
}

.hover\:scale-105:hover {
    transform: scale(1.05);
}

.hover\:-translate-y-1:hover {
    transform: translateY(-4px);
}
</style>
@endsection