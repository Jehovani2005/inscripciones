@extends('layouts.base')

@section('title', 'Disciplinas Disponibles')
@section('page-title', 'Disciplinas Deportivas y Culturales')
@section('page-subtitle', 'Selecciona hasta 2 disciplinas para participar')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Verificar registro --}}
    @php
        // $participante proviene del controlador
    @endphp

    @if ($participante)
        <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Hola, {{ Auth::user()->name }}</h3>
                    <p class="text-gray-600">Selecciona hasta <strong>2</strong> disciplinas en las que deseas participar.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Disciplinas seleccionadas</p>
                    <p class="text-xl font-bold text-blue-600" id="contador-disciplinas">0/2</p>
                </div>
            </div>
        </div>

        {{-- Mensajes de alerta --}}
        <div id="alert-container" class="mb-4"></div>

        {{-- Ofertas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="ofertas-container">
            @foreach ($ofertas as $oferta)
                @php
                    // contar inscritos activos
                    $ocupados = \App\Models\ParticipanteOferta::where('oferta_disciplina_id', $oferta->id)
                        ->whereNull('deleted_at')->count();
                    $disponibles = max(0, $oferta->capacidad - $ocupados);
                    $estado = $disponibles > 5 ? 'Disponible' : ($disponibles > 0 ? 'Casi lleno' : 'Lleno');
                    $estadoColor = $disponibles > 5 ? 'text-green-600' : ($disponibles > 0 ? 'text-yellow-600' : 'text-red-600');
                    $yaSeleccionado = in_array($oferta->id, $selecciones ?? []);
                @endphp

                <div class="card bg-white rounded-xl shadow-sm p-6 oferta-card" data-oferta-id="{{ $oferta->id }}">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 oferta-nombre">{{ $oferta->disciplina->nombre }}</h3>
                            <p class="text-sm text-gray-500 oferta-tipo">{{ $oferta->disciplina->tipo }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-blue-500 flex items-center justify-center text-white">
                            <i class="fas fa-star text-xl"></i>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4 oferta-desc">{{ Str::limit($oferta->disciplina->descripcion ?? '-', 120) }}</p>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Cupo</p>
                            <p class="text-sm font-medium text-gray-800"><span class="ocupados">{{ $ocupados }}</span> / <span class="capacidad">{{ $oferta->capacidad }}</span></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estado</p>
                            <p class="text-sm font-medium {{ $estadoColor }}">{{ $estado }}</p>
                        </div>
                    </div>

                    @if ($disponibles <= 0)
                        <button type="button" class="w-full btn bg-gray-400 cursor-not-allowed" disabled>
                            <i class="fas fa-times mr-2"></i>Sin cupo
                        </button>
                    @else
                        @if ($yaSeleccionado)
                            <button type="button" class="w-full btn btn-primary deseleccionar-btn" data-oferta-id="{{ $oferta->id }}">
                                <i class="fas fa-check mr-2"></i>Seleccionada
                            </button>
                        @else
                            <button type="button" class="w-full btn bg-gray-200 text-gray-700 hover:bg-gray-300 seleccionar-btn" data-oferta-id="{{ $oferta->id }}">
                                <i class="fas fa-plus mr-2"></i>Seleccionar
                            </button>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Contenedor de seleccionadas --}}
        <div class="card bg-white rounded-xl shadow-sm p-6 mb-6" id="disciplinas-seleccionadas-container" style="display:none;">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Disciplinas Seleccionadas</h3>
            <div id="disciplinas-seleccionadas" class="space-y-3"></div>
        </div>

        {{-- Botón confirmar (alternativa: la confirmación la hacemos al seleccionar; aquí lo dejo por si quieres un submit final) --}}
        <div class="flex justify-end space-x-4 mb-8">
            <a href="{{ url('/') }}" class="btn bg-gray-300 text-gray-700 hover:bg-gray-400">Cancelar</a>
            <button type="button" id="confirmar-inscripcion" class="btn btn-primary opacity-50 cursor-not-allowed" disabled>
                <i class="fas fa-check-circle mr-2"></i>Confirmar Inscripción
            </button>
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
                        <li>Aún no te has registrado. Regístrate primero para seleccionar las disciplinas en las que deseas participar.</li>
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
    const seleccionadas = new Set(@json($selecciones ?? [])); // contiene oferta ids ya inscritas
    const btnConfirmar = document.getElementById('confirmar-inscripcion');
    const contadorEl = document.getElementById('contador-disciplinas');
    const alertContainer = document.getElementById('alert-container');

    function mostrarAlerta(tipo, mensaje, timeout = 5000) {
        // tipo: 'error'|'success'|'info'
        const div = document.createElement('div');
        div.className = (tipo === 'success') ? 'bg-green-100 text-green-700 p-3 rounded mb-2' : (tipo === 'error') ? 'bg-red-100 text-red-700 p-3 rounded mb-2' : 'bg-blue-50 text-blue-700 p-3 rounded mb-2';
        div.textContent = mensaje;
        alertContainer.appendChild(div);
        if (timeout) setTimeout(()=> div.remove(), timeout);
    }

    function actualizarUIDesdeDOM() {
        // actualizar contador
        contadorEl.textContent = `${seleccionadas.size}/${MAX}`;

        // activar/desactivar confirmar
        if (seleccionadas.size > 0) {
            btnConfirmar.classList.remove('opacity-50', 'cursor-not-allowed');
            btnConfirmar.disabled = false;
        } else {
            btnConfirmar.classList.add('opacity-50', 'cursor-not-allowed');
            btnConfirmar.disabled = true;
        }

        // actualizar lista visual de seleccionadas
        const container = document.getElementById('disciplinas-seleccionadas-container');
        const lista = document.getElementById('disciplinas-seleccionadas');
        if (seleccionadas.size > 0) {
            container.style.display = 'block';
            lista.innerHTML = '';
            seleccionadas.forEach(ofertaId => {
                // buscar card para nombre
                const card = document.querySelector(`.oferta-card[data-oferta-id="${ofertaId}"]`);
                const nombre = card ? card.querySelector('.oferta-nombre').textContent.trim() : `Oferta ${ofertaId}`;
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-3 bg-blue-50 rounded-lg';
                item.innerHTML = `<div><p class="font-medium text-gray-800">${nombre}</p><p class="text-sm text-gray-600">Disciplina seleccionada</p></div>
                <button type="button" class="text-red-500 hover:text-red-700 quitar-disciplina" data-oferta-id="${ofertaId}"><i class="fas fa-times"></i></button>`;
                lista.appendChild(item);
            });

            // attach listeners remove
            document.querySelectorAll('.quitar-disciplina').forEach(btn => {
                btn.onclick = async function(){
                    const ofertaId = this.dataset.ofertaId;
                    await deseleccionar(ofertaId);
                };
            });
        } else {
            container.style.display = 'none';
            lista.innerHTML = '';
        }
    }

    async function seleccionar(ofertaId, btn) {
        // optimización visual: desactivar botón mientras request
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Procesando...';

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
                // si falla, mostrar mensaje del servidor
                mostrarAlerta('error', data.mensaje || 'Error al intentar inscribirte.');
                // si el error es por cupo, actualizar UI para reflejarlo
                if (resp.status === 422 && data.mensaje && data.mensaje.toLowerCase().includes('cupo')) {
                    // marcar como sin cupo en la tarjeta
                    marcarSinCupo(ofertaId);
                }
                return;
            }

            // éxito
            seleccionadas.add(ofertaId);
            mostrarAlerta('success', data.mensaje || 'Inscripción correcta.');
            actualizarContadoresEnCard(ofertaId, +1);
            actualizarButtonsAfterSelect(ofertaId);
        } catch (err) {
            console.error(err);
            mostrarAlerta('error', 'Error de red. Intenta de nuevo.');
        } finally {
            // reactivar botón solo si no quedó seleccionada (si quedó seleccionada será reemplazado por "Seleccionada")
            const card = document.querySelector(`.oferta-card[data-oferta-id="${ofertaId}"]`);
            const btnActual = card ? card.querySelector('.seleccionar-btn, .deseleccionar-btn') : null;
            if (btnActual && btnActual.classList.contains('seleccionar-btn')) {
                btnActual.disabled = false;
                btnActual.innerHTML = '<i class="fas fa-plus mr-2"></i>Seleccionar';
            }
            actualizarUIDesdeDOM();
        }
    }

    async function deseleccionar(ofertaId, btn = null) {
        // si btn viene, desactivar
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Procesando...';
        }

        try {
            const resp = await fetch("{{ route('disciplinas.deseleccionar') }}", {
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
                mostrarAlerta('error', data.mensaje || 'Error al intentar cancelar la inscripción.');
                return;
            }

            // éxito
            seleccionadas.delete(ofertaId);
            mostrarAlerta('success', data.mensaje || 'Inscripción cancelada.');
            actualizarContadoresEnCard(ofertaId, -1);
            actualizarButtonsAfterDeselect(ofertaId);
        } catch (err) {
            console.error(err);
            mostrarAlerta('error', 'Error de red. Intenta de nuevo.');
        } finally {
            // reactivar botón original si existe
            const card = document.querySelector(`.oferta-card[data-oferta-id="${ofertaId}"]`);
            const btnActual = card ? card.querySelector('.seleccionar-btn, .deseleccionar-btn') : null;
            if (btnActual && btnActual.classList.contains('seleccionar-btn')) {
                btnActual.disabled = false;
                btnActual.innerHTML = '<i class="fas fa-plus mr-2"></i>Seleccionar';
            }
            actualizarUIDesdeDOM();
        }
    }

    function actualizarContadoresEnCard(ofertaId, delta) {
        const card = document.querySelector(`.oferta-card[data-oferta-id="${ofertaId}"]`);
        if (!card) return;
        const ocupadosEl = card.querySelector('.ocupados');
        const capacidadEl = card.querySelector('.capacidad');
        let ocupados = parseInt(ocupadosEl.textContent) || 0;
        ocupados = ocupados + delta;
        ocupadosEl.textContent = ocupados;
        const capacidad = parseInt(capacidadEl.textContent) || 0;
        const disponibles = Math.max(0, capacidad - ocupados);

        // actualizar estado
        const estadoP = card.querySelector('[class*="text-"]') || null;
        if (estadoP) {
            if (disponibles > 5) {
                estadoP.textContent = 'Disponible';
                estadoP.className = 'text-green-600 text-sm font-medium';
            } else if (disponibles > 0) {
                estadoP.textContent = 'Casi lleno';
                estadoP.className = 'text-yellow-600 text-sm font-medium';
            } else {
                estadoP.textContent = 'Lleno';
                estadoP.className = 'text-red-600 text-sm font-medium';
                // reemplazar botón por "Sin cupo"
                const btn = card.querySelector('.seleccionar-btn');
                if (btn) {
                    btn.outerHTML = `<button type="button" class="w-full btn bg-gray-400 cursor-not-allowed" disabled><i class="fas fa-times mr-2"></i>Sin cupo</button>`;
                }
            }
        }
    }

    function marcarSinCupo(ofertaId) {
        const card = document.querySelector(`.oferta-card[data-oferta-id="${ofertaId}"]`);
        if (!card) return;
        const btn = card.querySelector('.seleccionar-btn');
        if (btn) {
            btn.outerHTML = `<button type="button" class="w-full btn bg-gray-400 cursor-not-allowed" disabled><i class="fas fa-times mr-2"></i>Sin cupo</button>`;
        }
        const estadoP = card.querySelector('[class*="text-"]');
        if (estadoP) {
            estadoP.textContent = 'Lleno';
            estadoP.className = 'text-red-600 text-sm font-medium';
        }
    }

    function actualizarButtonsAfterSelect(ofertaId) {
        // Cambiar boton seleccionar a deseleccionar
        const card = document.querySelector(`.oferta-card[data-oferta-id="${ofertaId}"]`);
        if (!card) return;
        const btn = card.querySelector('.seleccionar-btn');
        if (btn) {
            btn.outerHTML = `<button type="button" class="w-full btn btn-primary deseleccionar-btn" data-oferta-id="${ofertaId}"><i class="fas fa-check mr-2"></i>Seleccionada</button>`;
            // listener
            card.querySelector('.deseleccionar-btn').onclick = async function(){
                await deseleccionar(ofertaId, this);
            };
        }
    }

    function actualizarButtonsAfterDeselect(ofertaId) {
        const card = document.querySelector(`.oferta-card[data-oferta-id="${ofertaId}"]`);
        if (!card) return;
        const btn = card.querySelector('.deseleccionar-btn');
        const capacidad = parseInt(card.querySelector('.capacidad').textContent) || 0;
        const ocupados = parseInt(card.querySelector('.ocupados').textContent) || 0;
        const disponibles = Math.max(0, capacidad - ocupados);

        if (btn) {
            if (disponibles <= 0) {
                btn.outerHTML = `<button type="button" class="w-full btn bg-gray-400 cursor-not-allowed" disabled><i class="fas fa-times mr-2"></i>Sin cupo</button>`;
            } else {
                btn.outerHTML = `<button type="button" class="w-full btn bg-gray-200 text-gray-700 hover:bg-gray-300 seleccionar-btn" data-oferta-id="${ofertaId}"><i class="fas fa-plus mr-2"></i>Seleccionar</button>`;
                // listener
                const newBtn = card.querySelector('.seleccionar-btn');
                newBtn.onclick = async function(){ 
                    // validar límite local
                    if (seleccionadas.size >= MAX) {
                        mostrarAlerta('error', 'Solo puedes seleccionar hasta ' + MAX + ' disciplinas.');
                        return;
                    }
                    await seleccionar(ofertaId, this);
                };
            }
        }
    }

    // Attach initial listeners
    document.querySelectorAll('.seleccionar-btn').forEach(btn => {
        btn.onclick = async function(){
            const ofertaId = this.dataset.ofertaId;
            if (seleccionadas.size >= MAX) {
                mostrarAlerta('error', 'Solo puedes seleccionar hasta ' + MAX + ' disciplinas.');
                return;
            }
            await seleccionar(ofertaId, this);
        };
    });

    document.querySelectorAll('.deseleccionar-btn').forEach(btn => {
        btn.onclick = async function(){
            const ofertaId = this.dataset.ofertaId;
            await deseleccionar(ofertaId, this);
        };
    });

    // Confirmar inscripción (puedes adaptarlo para submit final si quieres)
    btnConfirmar?.addEventListener('click', function(){
        if (seleccionadas.size === 0) return;
        const lista = Array.from(seleccionadas);
        mostrarAlerta('info', 'Inscripción/selección enviada. Si ves errores, revisa los mensajes.');
        // opcional: aquí podrías enviar un único POST con todas las selecciones finales.
    });

    // Inicial UI
    actualizarUIDesdeDOM();

})();
</script>
@endsection
