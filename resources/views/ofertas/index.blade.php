@extends('layouts.base')

@section('title', 'Administrar Ofertas')
@section('page-title', 'Administrar Ofertas')
@section('page-subtitle', 'Editar, ver y eliminar ofertas de disciplinas')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header mejorado -->
    <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-sm p-6 mb-8 border border-blue-100">
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-tags text-blue-600 text-xl"></i>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Gestión de Ofertas</h2>
                <p class="text-sm text-gray-600 mt-1">Administra las ofertas de disciplinas disponibles. Edita detalles, fechas y capacidad según sea necesario.</p>
            </div>
        </div>
    </div>
    

    <!-- Contador de ofertas -->
    <div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-semibold text-gray-700">
        Ofertas Registradas <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full ml-2">{{ count($ofertas) }}</span>
    </h3>
    <div class="flex items-center space-x-3">
        <button id="btn-nueva-disciplina" class="btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>Nueva Disciplina
        </button>
        <div class="text-sm text-gray-500">
            <i class="fas fa-info-circle mr-1"></i>
            Las ofertas solo pueden eliminarse después del cierre de inscripciones
        </div>
    </div>
</div>


    <!-- Grid de ofertas -->
    @if(count($ofertas) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($ofertas as $oferta)
            @php
                $cupos = $oferta->cuposDisponibles();
                $estadoIns = \Carbon\Carbon::today()->gt(\Carbon\Carbon::parse($oferta->fin_inscripcion)) ? 'cerrada' : 'abierta';
                $porcentajeOcupacion = $oferta->capacidad > 0 ? round(($oferta->capacidad - $cupos) / $oferta->capacidad * 100) : 0;
            @endphp

            <div class="card bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100 oferta-card transform hover:-translate-y-1" data-oferta-id="{{ $oferta->id }}">
                <!-- Barra de estado superior -->
                <div class="h-1.5 w-full {{ $estadoIns === 'abierta' ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                
                <div class="p-5">
                    <!-- Header de la tarjeta -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <h3 class="text-lg font-bold text-gray-800 truncate mr-2">{{ $oferta->disciplina->nombre ?? 'Sin nombre' }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoIns === 'abierta' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $estadoIns === 'abierta' ? 'Abierta' : 'Cerrada' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($oferta->disciplina->descripcion ?? '-', 100) }}</p>
                        </div>
                    </div>

                    <!-- Barra de progreso de cupos -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Cupos ocupados</span>
                            <span>{{ $porcentajeOcupacion }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $porcentajeOcupacion > 80 ? 'bg-red-500' : ($porcentajeOcupacion > 50 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                 style="width: {{ $porcentajeOcupacion }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 text-right">
                            {{ $oferta->capacidad - $cupos }} de {{ $oferta->capacidad }} ocupados
                        </div>
                    </div>

                    <!-- Fechas -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-calendar-alt w-4 mr-2 text-blue-500"></i>
                            <span>Inicio: <strong>{{ \Carbon\Carbon::parse($oferta->inicio_inscripcion)->format('d/m/Y') }}</strong></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-calendar-times w-4 mr-2 text-blue-500"></i>
                            <span>Fin: <strong>{{ \Carbon\Carbon::parse($oferta->fin_inscripcion)->format('d/m/Y') }}</strong></span>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <button class="btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center editar-oferta" data-oferta='@json($oferta)'>
                            <i class="fas fa-edit mr-2"></i>Editar
                        </button>

                        @if(\Carbon\Carbon::today()->gt(\Carbon\Carbon::parse($oferta->fin_inscripcion)))
                            <button class="btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center eliminar-oferta" data-id="{{ $oferta->id }}">
                                <i class="fas fa-trash mr-2"></i>Eliminar
                            </button>
                        @else
                            <button class="btn bg-gray-200 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed flex items-center" disabled title="No se puede eliminar hasta que termine el periodo de inscripciones">
                                <i class="fas fa-lock mr-2"></i>Bloqueado
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
    <!-- Estado vacío -->
    <div class="card bg-white rounded-2xl shadow-sm p-12 text-center">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <i class="fas fa-tags text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay ofertas registradas</h3>
        <p class="text-gray-500 max-w-md mx-auto">Actualmente no hay ofertas de disciplinas disponibles. Crea una nueva oferta para comenzar.</p>
    </div>
    @endif
</div>

{{-- Modal de editar mejorado --}}
<div id="modal-editar" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-transform duration-300 scale-95 opacity-0" id="modal-content">
        <!-- Header del modal -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-edit text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Editar Oferta</h3>
                    <p class="text-sm text-gray-500">Actualiza los detalles de esta oferta</p>
                </div>
            </div>
            <button id="cerrar-modal" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="form-editar">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="oferta-id">
            
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la disciplina</label>
                        <input type="text" id="nombre" name="nombre" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" rows="3" placeholder="Describe la disciplina..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Inicio inscripción</label>
                            <input type="date" id="inicio_inscripcion" name="inicio_inscripcion" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fin inscripción</label>
                            <input type="date" id="fin_inscripcion" name="fin_inscripcion" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Capacidad (cupo máximo)</label>
                        <input type="number" id="capacidad" name="capacidad" min="1" class="form-input w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" required>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelar-modal" class="btn bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 px-5 py-2.5 rounded-lg transition-colors duration-200">Cancelar</button>
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal para nueva disciplina --}}
<div id="modal-nueva" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-transform duration-300 scale-95 opacity-0" id="modal-nueva-content">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-plus text-green-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Registrar Nueva Disciplina</h3>
                    <p class="text-sm text-gray-500">Agrega una nueva disciplina con su oferta disponible</p>
                </div>
            </div>
            <button id="cerrar-modal-nueva" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="form-nueva-disciplina">
            @csrf
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                        <input type="text" name="nombre" class="form-input w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-colors duration-200" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="descripcion" class="form-input w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-colors duration-200" rows="3" placeholder="Describe la disciplina..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Inicio de inscripciones</label>
                            <input type="date" name="inicio_inscripcion" class="form-input w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-colors duration-200" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fin de inscripciones</label>
                            <input type="date" name="fin_inscripcion" class="form-input w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-colors duration-200" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Capacidad</label>
                        <input type="number" name="capacidad" min="1" class="form-input w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-colors duration-200" required>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-2xl flex justify-end space-x-3">
                <button type="button" id="cancelar-modal-nueva" class="btn bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 px-5 py-2.5 rounded-lg transition-colors duration-200">Cancelar</button>
                <button type="submit" class="btn bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition-colors duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>Guardar
                </button>
            </div>
        </form>
    </div>
</div>


<script>
(function(){
    // Helpers mejorados
    function mostrarAlerta(mensaje, tipo = 'info') {
        // En un entorno real, usarías una librería como SweetAlert2
        // Por ahora usamos alert nativo pero con mensajes más descriptivos
        const titulos = {
            'success': 'Éxito',
            'error': 'Error',
            'info': 'Información'
        };
        alert(`${titulos[tipo] || 'Información'}: ${mensaje}`);
    }

    // Animación de apertura del modal
    function abrirModal() {
        const modal = document.getElementById('modal-editar');
        const content = document.getElementById('modal-content');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    // Animación de cierre del modal
    function cerrarModal() {
        const modal = document.getElementById('modal-editar');
        const content = document.getElementById('modal-content');
        
        modal.classList.remove('opacity-100');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    // Abrir modal y rellenar campos
    document.querySelectorAll('.editar-oferta').forEach(btn => {
        btn.addEventListener('click', function() {
            const oferta = JSON.parse(this.dataset.oferta);

            document.getElementById('oferta-id').value = oferta.id;
            document.getElementById('nombre').value = oferta.disciplina ? (oferta.disciplina.nombre ?? '') : '';
            document.getElementById('descripcion').value = oferta.disciplina ? (oferta.disciplina.descripcion ?? '') : '';
            document.getElementById('inicio_inscripcion').value = oferta.inicio_inscripcion || '';
            document.getElementById('fin_inscripcion').value = oferta.fin_inscripcion || '';
            document.getElementById('capacidad').value = oferta.capacidad || 1;

            abrirModal();
        });
    });

    // Cerrar modal (ambos botones)
    document.getElementById('cerrar-modal').addEventListener('click', cerrarModal);
    document.getElementById('cancelar-modal').addEventListener('click', cerrarModal);

    // Cerrar modal al hacer clic fuera
    document.getElementById('modal-editar').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModal();
        }
    });

    // Submit editar via AJAX
    document.getElementById('form-editar').addEventListener('submit', async function(e){
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Mostrar estado de carga
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
        
        const id = document.getElementById('oferta-id').value;
        const data = {
            nombre: document.getElementById('nombre').value,
            descripcion: document.getElementById('descripcion').value,
            inicio_inscripcion: document.getElementById('inicio_inscripcion').value,
            fin_inscripcion: document.getElementById('fin_inscripcion').value,
            capacidad: document.getElementById('capacidad').value
        };

        try {
            const resp = await fetch(`/ofertas/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });

            const json = await resp.json();
            
            // Restaurar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            
            if (!resp.ok) {
                mostrarAlerta(json.mensaje || 'Error al guardar los cambios', 'error');
                return;
            }

            mostrarAlerta(json.mensaje || 'Cambios guardados exitosamente', 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
            
        } catch (err) {
            console.error(err);
            // Restaurar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            mostrarAlerta('Error de conexión. Intenta nuevamente.', 'error');
        }

    // === NUEVA DISCIPLINA ===
const modalNueva = document.getElementById('modal-nueva');
const modalNuevaContent = document.getElementById('modal-nueva-content');
const btnNueva = document.getElementById('btn-nueva-disciplina');

btnNueva.addEventListener('click', () => {
    modalNueva.classList.remove('hidden');
    modalNueva.classList.add('flex');
    setTimeout(() => {
        modalNueva.classList.add('opacity-100');
        modalNuevaContent.classList.remove('scale-95', 'opacity-0');
        modalNuevaContent.classList.add('scale-100', 'opacity-100');
    }, 10);
});

function cerrarModalNueva() {
    modalNueva.classList.remove('opacity-100');
    modalNuevaContent.classList.remove('scale-100', 'opacity-100');
    modalNuevaContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modalNueva.classList.add('hidden');
        modalNueva.classList.remove('flex');
    }, 300);
}

document.getElementById('cerrar-modal-nueva').addEventListener('click', cerrarModalNueva);
document.getElementById('cancelar-modal-nueva').addEventListener('click', cerrarModalNueva);
modalNueva.addEventListener('click', e => { if (e.target === modalNueva) cerrarModalNueva(); });

document.getElementById('form-nueva-disciplina').addEventListener('submit', async e => {
    e.preventDefault();

    const form = e.target;
    const data = Object.fromEntries(new FormData(form));

    try {
        const resp = await fetch('/ofertas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });

        const json = await resp.json();
        if (!resp.ok) {
            alert(json.mensaje || 'Error al registrar la disciplina.');
            return;
        }

        alert(json.mensaje || 'Disciplina registrada correctamente.');
        cerrarModalNueva();
        location.reload();

    } catch (err) {
        console.error(err);
        alert('Error de conexión. Intenta nuevamente.');
    }
});

    });

    // Eliminar oferta
    document.querySelectorAll('.eliminar-oferta').forEach(btn => {
        btn.addEventListener('click', async function(){
            const id = this.dataset.id;
            if (!confirm('¿Estás seguro de que deseas eliminar esta oferta?\n\nEsta acción eliminará permanentemente la oferta y todas las inscripciones relacionadas. Esta acción no se puede deshacer.')) return;

            // Mostrar estado de carga
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Eliminando...';
            this.disabled = true;

            try {
                const resp = await fetch(`/ofertas/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const json = await resp.json();
                
                if (!resp.ok) {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    mostrarAlerta(json.mensaje || 'Error al eliminar la oferta', 'error');
                    return;
                }
                
                mostrarAlerta(json.mensaje || 'Oferta eliminada exitosamente', 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
                
            } catch (err) {
                console.error(err);
                this.innerHTML = originalText;
                this.disabled = false;
                mostrarAlerta('Error de conexión. Intenta nuevamente.', 'error');
            }
        });
    });

    // === NUEVA DISCIPLINA ===
const modalNueva = document.getElementById('modal-nueva');
const modalNuevaContent = document.getElementById('modal-nueva-content');
const btnNueva = document.getElementById('btn-nueva-disciplina');

btnNueva.addEventListener('click', () => {
    modalNueva.classList.remove('hidden');
    modalNueva.classList.add('flex');
    setTimeout(() => {
        modalNueva.classList.add('opacity-100');
        modalNuevaContent.classList.remove('scale-95', 'opacity-0');
        modalNuevaContent.classList.add('scale-100', 'opacity-100');
    }, 10);
});

function cerrarModalNueva() {
    modalNueva.classList.remove('opacity-100');
    modalNuevaContent.classList.remove('scale-100', 'opacity-100');
    modalNuevaContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modalNueva.classList.add('hidden');
        modalNueva.classList.remove('flex');
    }, 300);
}

document.getElementById('cerrar-modal-nueva').addEventListener('click', cerrarModalNueva);
document.getElementById('cancelar-modal-nueva').addEventListener('click', cerrarModalNueva);
modalNueva.addEventListener('click', e => { if (e.target === modalNueva) cerrarModalNueva(); });

document.getElementById('form-nueva-disciplina').addEventListener('submit', async e => {
    e.preventDefault();

    const form = e.target;
    const data = Object.fromEntries(new FormData(form));

    try {
        const resp = await fetch('/ofertas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });

        const json = await resp.json();
        if (!resp.ok) {
            alert(json.mensaje || 'Error al registrar la disciplina.');
            return;
        }

        alert(json.mensaje || 'Disciplina registrada correctamente.');
        cerrarModalNueva();
        location.reload();

    } catch (err) {
        console.error(err);
        alert('Error de conexión. Intenta nuevamente.');
    }
});

})();
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.transition-all {
    transition: all 0.3s ease;
}

.hover\:shadow-md:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.transform {
    transform: translateX(0) translateY(0) rotate(0) skewX(0) skewY(0) scaleX(1) scaleY(1);
}
</style>
@endsection