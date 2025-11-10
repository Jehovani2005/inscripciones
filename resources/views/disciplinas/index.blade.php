@extends('layouts.base')

@section('title', 'Disciplinas Disponibles')
@section('page-title', 'Disciplinas Deportivas y Culturales')
@section('page-subtitle', 'Solicita tu participación en hasta 2 disciplinas')

@section('content')
<div class="max-w-6xl mx-auto">

    @if ($participante)
        <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Hola, {{ Auth::user()->name }}</h3>
                    <p class="text-gray-600">Puedes solicitar tu participación en un máximo de <strong>2</strong> disciplinas.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Solicitudes enviadas</p>
                    <p class="text-xl font-bold text-blue-600" id="contador-disciplinas">0/2</p>
                </div>
            </div>
        </div>

        <div id="alert-container" class="mb-4"></div>

        {{-- Listado de ofertas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="ofertas-container">
            @foreach ($ofertas as $oferta)
                @php
                    $ocupados = \App\Models\ParticipanteOferta::where('oferta_disciplina_id', $oferta->id)
                        ->where('estado', 'aprobada')
                        ->count();
                    $disponibles = max(0, $oferta->capacidad - $ocupados);
                    $estadoCupo = $disponibles > 5 ? 'Disponible' : ($disponibles > 0 ? 'Casi lleno' : 'Lleno');
                    $estadoColor = $disponibles > 5 ? 'text-green-600' : ($disponibles > 0 ? 'text-yellow-600' : 'text-red-600');

                    // obtener solicitud si existe
                    $solicitud = \App\Models\ParticipanteOferta::where('participante_id', $participante->id)
                        ->where('oferta_disciplina_id', $oferta->id)
                        ->first();
                @endphp

                <div class="card bg-white rounded-xl shadow-sm p-6 oferta-card" data-oferta-id="{{ $oferta->id }}">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 oferta-nombre">{{ $oferta->disciplina->nombre }}</h3>
                            <p class="text-sm text-gray-500">{{ $oferta->disciplina->tipo }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-blue-500 flex items-center justify-center text-white">
                            <i class="fas fa-medal text-xl"></i>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($oferta->disciplina->descripcion ?? 'Sin descripción', 120) }}</p>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Cupo</p>
                            <p class="text-sm font-medium text-gray-800"><span class="ocupados">{{ $ocupados }}</span> / <span class="capacidad">{{ $oferta->capacidad }}</span></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estado del cupo</p>
                            <p class="text-sm font-medium {{ $estadoColor }}">{{ $estadoCupo }}</p>
                        </div>
                    </div>

                    {{-- BOTONES SEGÚN ESTADO DE LA SOLICITUD --}}
                    @if ($solicitud)
                        @if ($solicitud->estado === 'pendiente')
                            <button type="button" class="w-full btn bg-yellow-100 text-yellow-700 cursor-default">
                                <i class="fas fa-hourglass-half mr-2"></i>Solicitud Pendiente
                            </button>
                        @elseif ($solicitud->estado === 'aprobada')
                            <button type="button" class="w-full btn bg-green-100 text-green-700 cursor-default">
                                <i class="fas fa-check mr-2"></i>Aprobada
                            </button>
                        @elseif ($solicitud->estado === 'rechazada')
                            <button type="button" class="w-full btn bg-red-100 text-red-700 cursor-default">
                                <i class="fas fa-times mr-2"></i>Rechazada
                            </button>
                        @endif
                    @else
                        @if ($disponibles <= 0)
                            <button type="button" class="w-full btn bg-gray-400 cursor-not-allowed" disabled>
                                <i class="fas fa-ban mr-2"></i>Sin cupo
                            </button>
                        @else
                            <button type="button" class="w-full btn bg-gray-200 text-gray-700 hover:bg-gray-300 solicitar-btn" data-oferta-id="{{ $oferta->id }}">
                                <i class="fas fa-paper-plane mr-2"></i>Solicitar inscripción
                            </button>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Contenedor dinámico de solicitudes --}}
        <div class="card bg-white rounded-xl shadow-sm p-6 mb-8" id="disciplinas-solicitadas-container" style="display:none;">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tus solicitudes</h3>
            <div id="disciplinas-solicitadas" class="space-y-3"></div>
        </div>

    @else
        <div class="card bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-blue-800">Información Importante</h3>
                    <ul class="mt-2 text-blue-700 list-disc list-inside space-y-1">
                        <li>Aún no te has registrado. Completa tu registro y carga tus documentos antes de elegir disciplinas.</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

</div>

{{-- Scripts --}}
<script>
(function(){
    const MAX = 2;
    const alertContainer = document.getElementById('alert-container');
    const contadorEl = document.getElementById('contador-disciplinas');
    let solicitudes = @json($selecciones ?? []); // si el backend las envía

    function mostrarAlerta(tipo, mensaje, timeout = 4000) {
        const div = document.createElement('div');
        div.className = tipo === 'success'
            ? 'bg-green-100 text-green-700 p-3 rounded mb-2'
            : tipo === 'error'
            ? 'bg-red-100 text-red-700 p-3 rounded mb-2'
            : 'bg-blue-100 text-blue-700 p-3 rounded mb-2';
        div.textContent = mensaje;
        alertContainer.appendChild(div);
        if (timeout) setTimeout(() => div.remove(), timeout);
    }

    function actualizarContador() {
        contadorEl.textContent = `${solicitudes.length}/${MAX}`;
    }

    async function solicitarInscripcion(ofertaId, btn) {
        if (solicitudes.length >= MAX) {
            mostrarAlerta('error', 'Solo puedes solicitar hasta 2 disciplinas.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enviando...';

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
                mostrarAlerta('error', data.mensaje || 'Error al enviar solicitud.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Solicitar inscripción';
                return;
            }

            solicitudes.push(ofertaId);
            mostrarAlerta('success', data.mensaje || 'Solicitud enviada correctamente.');
            btn.outerHTML = `<button class="w-full btn bg-yellow-100 text-yellow-700 cursor-default"><i class="fas fa-hourglass-half mr-2"></i>Solicitud Pendiente</button>`;
            actualizarContador();

        } catch (error) {
            console.error(error);
            mostrarAlerta('error', 'Error de conexión. Intenta de nuevo.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Solicitar inscripción';
        }
    }

    document.querySelectorAll('.solicitar-btn').forEach(btn => {
        btn.addEventListener('click', async function(){
            await solicitarInscripcion(this.dataset.ofertaId, this);
        });
    });

    actualizarContador();

})();
</script>
@endsection
