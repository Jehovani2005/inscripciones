@extends('layouts.base')

@section('title', 'Validación de Inscripciones')
@section('page-title', 'Validación de Inscripciones')
@section('page-subtitle', 'Revisa y valida los documentos de los participantes')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Filtros --}}
    <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
        <form method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <h2 class="text-lg font-semibold text-gray-800">Filtros</h2>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <select name="estado" class="form-input">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado')=='pendiente'?'selected':'' }}>Pendiente</option>
                    <option value="aprobada" {{ request('estado')=='aprobada'?'selected':'' }}>Aprobada</option>
                    <option value="rechazada" {{ request('estado')=='rechazada'?'selected':'' }}>Rechazada</option>
                </select>
                <select name="disciplina" class="form-input">
                    <option value="">Todas las disciplinas</option>
                    @foreach(\App\Models\Disciplina::all() as $disc)
                        <option value="{{ $disc->nombre }}" {{ request('disciplina')==$disc->nombre?'selected':'' }}>{{ $disc->nombre }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary"><i class="fas fa-filter mr-2"></i>Filtrar</button>
            </div>
        </form>
    </div>

    {{-- Lista de solicitudes --}}
    <div class="card bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Solicitudes de Inscripción</h2>

        @if ($solicitudes->isEmpty())
            <p class="text-gray-500">No hay solicitudes para mostrar.</p>
        @else
            <div class="space-y-6">
                @foreach ($solicitudes as $s)
                    @php
                        // Colores por estado
                        $colorEstado = match($s->estado) {
                            'aprobada' => 'bg-green-100 text-green-800',
                            'rechazada' => 'bg-red-100 text-red-800',
                            default => 'bg-yellow-100 text-yellow-800',
                        };
                    @endphp

                    <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 transition-colors">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex items-start space-x-4 mb-4 lg:mb-0">
                                <img src="{{ Storage::url($s->participante->fotografia_path) }}" class="w-16 h-16 rounded-full object-cover" alt="Foto">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $s->participante->nombre_completo }}</h3>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span class="badge bg-blue-100 text-blue-800">
                                            <i class="fas fa-id-card mr-1"></i>{{ $s->participante->numero_trabajador }}
                                        </span>
                                        <span class="badge bg-purple-100 text-purple-800">
                                            <i class="fas fa-running mr-1"></i>{{ $s->oferta->disciplina->nombre }}
                                        </span>
                                        <span class="badge {{ $colorEstado }} capitalize">
                                            <i class="fas fa-flag mr-1"></i>{{ $s->estado }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <button type="button" class="btn bg-green-600 text-white hover:bg-green-700 ver-documentos" data-id="{{ $s->id }}">
                                    <i class="fas fa-eye mr-2"></i>Ver Documentos
                                </button>
                            </div>
                        </div>

                        {{-- Documentos ocultos --}}
                        <div class="hidden mt-6 border-t pt-6 documentos-container" id="docs-{{ $s->id }}">
                            <h4 class="font-semibold text-gray-800 mb-3">Documentos</h4>
                            <ul class="list-disc list-inside text-blue-700 text-sm">
                                <li><a href="{{ Storage::url($s->participante->constancia_laboral_path) }}" target="_blank">Constancia Laboral</a></li>
                                <li><a href="{{ Storage::url($s->participante->comprobante_pago_path) }}" target="_blank">CFDI/Recibo de Nómina</a></li>
                            </ul>

                            {{-- Acciones --}}
                            <div class="mt-4 flex space-x-2">
                                <button type="button" class="btn bg-green-600 text-white hover:bg-green-700 aprobar-inscripcion" data-id="{{ $s->id }}">
                                    <i class="fas fa-check mr-2"></i>Aprobar
                                </button>
                                <button type="button" class="btn bg-red-600 text-white hover:bg-red-700 rechazar-inscripcion" data-id="{{ $s->id }}">
                                    <i class="fas fa-times mr-2"></i>Rechazar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Script --}}
<script>
document.querySelectorAll('.ver-documentos').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const cont = document.getElementById('docs-' + id);
        cont.classList.toggle('hidden');
        this.innerHTML = cont.classList.contains('hidden')
            ? '<i class="fas fa-eye mr-2"></i>Ver Documentos'
            : '<i class="fas fa-eye-slash mr-2"></i>Ocultar Documentos';
    });
});

document.querySelectorAll('.aprobar-inscripcion').forEach(btn => {
    btn.addEventListener('click', async function() {
        const id = this.dataset.id;
        if (confirm('¿Aprobar esta inscripción?')) {
            const resp = await fetch(`/validaciones/aprobar/${id}`, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            });
            const data = await resp.json();
            alert(data.mensaje);
            location.reload();
        }
    });
});

document.querySelectorAll('.rechazar-inscripcion').forEach(btn => {
    btn.addEventListener('click', async function() {
        const id = this.dataset.id;
        const motivo = prompt('Motivo del rechazo:');
        if (motivo) {
            const resp = await fetch(`/validaciones/rechazar/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({motivo})
            });
            const data = await resp.json();
            alert(data.mensaje);
            location.reload();
        }
    });
});
</script>
@endsection
