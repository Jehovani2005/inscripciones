@extends('layouts.base')

@section('title', 'Validación de Inscripciones')
@section('page-title', 'Validación de Inscripciones')
@section('page-subtitle', 'Revisa y valida los documentos de los participantes')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header mejorado --}}
    <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-sm p-6 mb-8 border border-blue-100">
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-blue-600 text-xl"></i>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Validación de Inscripciones</h2>
                <p class="text-sm text-gray-600 mt-1">Revisa, aprueba o rechaza las solicitudes de inscripción verificando los documentos adjuntos.</p>
            </div>
        </div>
    </div>

    {{-- Filtros mejorados --}}
    <div class="card bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Filtrar Solicitudes</h3>
                <p class="text-sm text-gray-500">Encuentra rápidamente las solicitudes que necesitas revisar</p>
            </div>
            
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative">
                        <select name="estado" class="form-select pl-10 pr-8 py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200 appearance-none bg-white">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('estado')=='pendiente'?'selected':'' }}>Pendiente</option>
                            <option value="aprobada" {{ request('estado')=='aprobada'?'selected':'' }}>Aprobada</option>
                            <option value="rechazada" {{ request('estado')=='rechazada'?'selected':'' }}>Rechazada</option>
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-filter text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select name="disciplina" class="form-select pl-10 pr-8 py-2.5 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200 appearance-none bg-white">
                            <option value="">Todas las disciplinas</option>
                            @foreach(\App\Models\Disciplina::all() as $disc)
                                <option value="{{ $disc->nombre }}" {{ request('disciplina')==$disc->nombre?'selected':'' }}>{{ $disc->nombre }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-running text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <button class="btn bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>Filtrar
                </button>
            </form>
        </div>
    </div>

    {{-- Estadísticas rápidas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="card bg-white rounded-xl shadow-sm p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $solicitudes->where('estado', 'pendiente')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="card bg-white rounded-xl shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Aprobadas</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $solicitudes->where('estado', 'aprobada')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="card bg-white rounded-xl shadow-sm p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rechazadas</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $solicitudes->where('estado', 'rechazada')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de solicitudes mejorada --}}
    <div class="card bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Solicitudes de Inscripción</h2>
                <p class="text-sm text-gray-500 mt-1">Total: {{ $solicitudes->count() }} solicitudes encontradas</p>
            </div>
        </div>

        @if ($solicitudes->isEmpty())
            {{-- Estado vacío --}}
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No hay solicitudes</h3>
                <p class="text-gray-500 max-w-md mx-auto">No se encontraron solicitudes que coincidan con los criterios de búsqueda.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($solicitudes as $s)
                    @php
                        // Colores y estilos por estado
                        $estadoConfig = match($s->estado) {
                            'aprobada' => [
                                'color' => 'bg-green-100 text-green-800 border-green-200',
                                'icon' => 'fa-check-circle',
                                'badge' => 'Aprobada'
                            ],
                            'rechazada' => [
                                'color' => 'bg-red-100 text-red-800 border-red-200',
                                'icon' => 'fa-times-circle',
                                'badge' => 'Rechazada'
                            ],
                            default => [
                                'color' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'icon' => 'fa-clock',
                                'badge' => 'Pendiente'
                            ],
                        };
                    @endphp

                    <div class="border border-gray-200 rounded-xl p-5 hover:border-blue-300 transition-all duration-300 bg-white hover:shadow-md">
                        {{-- Header de la solicitud --}}
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div class="flex items-start space-x-4 flex-1">
                                <div class="relative">
                                    <img src="{{ Storage::url($s->participante->fotografia_path) }}" 
                                         class="w-16 h-16 rounded-xl object-cover border-2 border-gray-100" 
                                         alt="Foto de {{ $s->participante->nombre_completo }}"
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiByeD0iMTIiIGZpbGw9IiNGM0Y0RjYiLz4KPHBhdGggZD0iTTMyIDM2QzM2LjQxODMgMzYgNDAgMzIuNDE4MyA0MCAyOEM0MCAyMy41ODE3IDM2LjQxODMgMjAgMzIgMjBDMjcuNTgxNyAyMCAyNCAyMy41ODE3IDI0IDI4QzI0IDMyLjQxODMgMjcuNTgxNyAzNiAzMiAzNloiIGZpbGw9IiNEOEUxRUEiLz4KPHBhdGggZD0iTTQ0IDUyQzQ0IDQ2LjQ3NzIgMzkuNTIyOCA0MiAzNCA0MkgzMEMyNC40NzcyIDQyIDIwIDQ2LjQ3NzIgMjAgNTJWNTRDMjAgNTUuMTA0NiAyMC44OTU0IDU2IDIyIDU2SDQyQzQzLjEwNDYgNTYgNDQgNTUuMTA0NiA0NCA1NFY1MloiIGZpbGw9IiNEOEUxRUEiLz4KPC9zdmc+'">
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 {{ $estadoConfig['color'] }} rounded-full border-2 border-white flex items-center justify-center">
                                        <i class="fas {{ $estadoConfig['icon'] }} text-xs"></i>
                                    </div>
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $s->participante->nombre_completo }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoConfig['color'] }} border {{ $estadoConfig['color'] }}">
                                            <i class="fas {{ $estadoConfig['icon'] }} mr-1"></i>
                                            {{ $estadoConfig['badge'] }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-sm">
                                            <i class="fas fa-id-card mr-1.5 text-sm"></i>
                                            {{ $s->participante->numero_trabajador }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 text-sm">
                                            <i class="fas fa-running mr-1.5 text-sm"></i>
                                            {{ $s->oferta->disciplina->nombre }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-50 text-gray-700 text-sm">
                                            <i class="fas fa-calendar mr-1.5 text-sm"></i>
                                            {{ \Carbon\Carbon::parse($s->created_at)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-2">
                                <button type="button" class="btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 flex items-center ver-documentos" data-id="{{ $s->id }}">
                                    <i class="fas fa-eye mr-2"></i>Ver Documentos
                                </button>
                            </div>
                        </div>

                        {{-- Documentos expandibles --}}
                        <div class="hidden mt-6 border-t pt-6 documentos-container" id="docs-{{ $s->id }}">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-folder-open mr-2 text-blue-500"></i>
                                    Documentos Adjuntos
                                </h4>
                                <span class="text-sm text-gray-500">Haz clic para visualizar</span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <a href="{{ Storage::url($s->participante->fotografia_path) }}" target="_blank" 
                                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors duration-200 group">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                        <i class="fas fa-camera text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">Fotografía</p>
                                        <p class="text-xs text-gray-500">Identificación</p>
                                    </div>
                                </a>
                                
                                <a href="{{ Storage::url($s->participante->constancia_laboral_path) }}" target="_blank" 
                                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-colors duration-200 group">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors duration-200">
                                        <i class="fas fa-file-contract text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">Constancia Laboral</p>
                                        <p class="text-xs text-gray-500">Empleo actual</p>
                                    </div>
                                </a>
                                
                                <a href="{{ Storage::url($s->participante->comprobante_pago_path) }}" target="_blank" 
                                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-colors duration-200 group">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                        <i class="fas fa-receipt text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">Comprobante de Pago</p>
                                        <p class="text-xs text-gray-500">CFDI/Nómina</p>
                                    </div>
                                </a>
                            </div>

                            {{-- Acciones: solo si está pendiente --}}
                            @if($s->estado === 'pendiente')
                                <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4 border-t border-gray-200">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                            Revisa todos los documentos antes de tomar una decisión
                                        </p>
                                    </div>
                                    <div class="flex gap-3">
                                        <button type="button" class="btn bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg transition-colors duration-200 flex items-center aprobar-inscripcion" data-id="{{ $s->id }}">
                                            <i class="fas fa-check mr-2"></i>Aprobar
                                        </button>
                                        <button type="button" class="btn bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg transition-colors duration-200 flex items-center rechazar-inscripcion" data-id="{{ $s->id }}">
                                            <i class="fas fa-times mr-2"></i>Rechazar
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-500 flex items-center justify-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Esta solicitud ya fue {{ $s->estado }} el {{ \Carbon\Carbon::parse($s->updated_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Script mejorado --}}
<script>
(function(){
    // Helpers mejorados
    function mostrarAlerta(mensaje, tipo = 'info') {
        // En un entorno real, usarías SweetAlert2
        const titulos = {
            'success': 'Éxito',
            'error': 'Error',
            'info': 'Información'
        };
        alert(`${titulos[tipo] || 'Información'}: ${mensaje}`);
    }

    function toggleLoading(button, isLoading) {
        if (isLoading) {
            button.disabled = true;
            const originalText = button.innerHTML;
            button.setAttribute('data-original-text', originalText);
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Procesando...';
        } else {
            button.disabled = false;
            const originalText = button.getAttribute('data-original-text');
            if (originalText) {
                button.innerHTML = originalText;
            }
        }
    }

    // Toggle documentos
    document.querySelectorAll('.ver-documentos').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const cont = document.getElementById('docs-' + id);
            const isHidden = cont.classList.contains('hidden');
            
            // Cerrar otros documentos abiertos
            document.querySelectorAll('.documentos-container').forEach(doc => {
                if (doc.id !== 'docs-' + id) {
                    doc.classList.add('hidden');
                    const otherBtn = document.querySelector(`[data-id="${doc.id.split('-')[1]}"]`);
                    if (otherBtn) {
                        otherBtn.innerHTML = '<i class="fas fa-eye mr-2"></i>Ver Documentos';
                    }
                }
            });
            
            // Toggle actual
            cont.classList.toggle('hidden');
            this.innerHTML = cont.classList.contains('hidden')
                ? '<i class="fas fa-eye mr-2"></i>Ver Documentos'
                : '<i class="fas fa-eye-slash mr-2"></i>Ocultar Documentos';
                
            // Scroll suave si se abre
            if (!cont.classList.contains('hidden')) {
                cont.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    });

    // Aprobar inscripción
    document.querySelectorAll('.aprobar-inscripcion').forEach(btn => {
        btn.addEventListener('click', async function() {
            if (!confirm('¿Estás seguro de que deseas APROBAR esta inscripción?\n\nEl participante será notificado y podrá acceder a la disciplina.')) return;
            
            const id = this.dataset.id;
            toggleLoading(this, true);
            
            try {
                const resp = await fetch(`/validaciones/aprobar/${id}`, {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                });
                const data = await resp.json();
                
                if (resp.ok) {
                    mostrarAlerta(data.mensaje || 'Inscripción aprobada exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarAlerta(data.mensaje || 'Error al aprobar la inscripción', 'error');
                    toggleLoading(this, false);
                }
            } catch (err) {
                console.error(err);
                mostrarAlerta('Error de conexión. Intenta nuevamente.', 'error');
                toggleLoading(this, false);
            }
        });
    });

    // Rechazar inscripción
    document.querySelectorAll('.rechazar-inscripcion').forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            const motivo = prompt('Por favor, indica el motivo del rechazo:\n\nEl participante recibirá esta información.');
            
            if (motivo && motivo.trim().length > 0) {
                if (!confirm('¿Estás seguro de que deseas RECHAZAR esta inscripción?\n\nEl participante será notificado con el motivo indicado.')) return;
                
                toggleLoading(this, true);
                
                try {
                    const resp = await fetch(`/validaciones/rechazar/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({motivo: motivo.trim()})
                    });
                    const data = await resp.json();
                    
                    if (resp.ok) {
                        mostrarAlerta(data.mensaje || 'Inscripción rechazada exitosamente', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        mostrarAlerta(data.mensaje || 'Error al rechazar la inscripción', 'error');
                        toggleLoading(this, false);
                    }
                } catch (err) {
                    console.error(err);
                    mostrarAlerta('Error de conexión. Intenta nuevamente.', 'error');
                    toggleLoading(this, false);
                }
            } else if (motivo !== null) {
                alert('Debes proporcionar un motivo para rechazar la inscripción.');
            }
        });
    });

})();
</script>

<style>
.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}

.transition-all {
    transition: all 0.3s ease;
}

.hover\:shadow-md:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>
@endsection