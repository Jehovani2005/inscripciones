@extends('layouts.base')

@section('title', 'Reportes')
@section('page-title', 'Reportes')
@section('page-subtitle', 'Descarga reportes y visualiza estadísticas generales')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header principal --}}
    <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-sm p-6 mb-8 border border-blue-100">
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Panel de Reportes</h2>
                <p class="text-sm text-gray-600 mt-1">Genera reportes y visualiza estadísticas del sistema</p>
            </div>
        </div>
    </div>

    {{-- ADMINISTRADOR --}}
    @if ($user->rol === 'Administrador')
        <div class="card bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-file-excel text-green-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Reporte por Disciplina</h3>
                    <p class="text-sm text-gray-500">Genera un reporte detallado de participantes por disciplina</p>
                </div>
            </div>
            
            <form method="GET" action="{{ route('reportes.porDisciplina') }}" class="bg-gray-50 rounded-xl p-5">
                <div class="flex flex-col lg:flex-row items-start lg:items-end gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-running mr-2 text-blue-500"></i>
                            Seleccionar Disciplina
                        </label>
                        <select name="disciplina_id" class="form-select w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-colors duration-200" required>
                            <option value="">-- Selecciona una disciplina --</option>
                            @foreach($disciplinas as $d)
                                <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center transform hover:scale-105">
                        <i class="fas fa-download mr-2"></i>
                        <span>Descargar Excel</span>
                    </button>
                </div>
                
                <div class="mt-3 flex items-center text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-2 text-green-500"></i>
                    <span>El reporte incluirá todos los participantes de la disciplina seleccionada</span>
                </div>
            </form>
        </div>
    @endif

    {{-- SUPERVISOR --}}
    @if ($user->rol === 'Supervisor')
        {{-- Reportes consolidados --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="card bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-table text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Reporte Consolidado</h3>
                        <p class="text-sm text-gray-500">Descarga el reporte completo del sistema</p>
                    </div>
                </div>
                
                <p class="text-gray-600 text-sm mb-4">
                    Este reporte incluye todos los participantes, disciplinas y estados de inscripción en un solo archivo.
                </p>
                
                <a href="{{ route('reportes.consolidado') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white w-full py-3 rounded-lg transition-colors duration-200 flex items-center justify-center transform hover:scale-105">
                    <i class="fas fa-download mr-2"></i>
                    <span>Descargar Consolidado (Excel)</span>
                </a>
            </div>

            {{-- Resumen rápido --}}
            <div class="card bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-line text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Resumen General</h3>
                        <p class="text-sm text-gray-500">Vista rápida de las estadísticas</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Total de disciplinas activas:</span>
                        <span class="font-semibold text-gray-800">{{ $disciplinas->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">Ofertas disponibles:</span>
                        <span class="font-semibold text-gray-800">{{ $ofertasCount ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ESTADÍSTICAS DETALLADAS --}}
        <div class="card bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-chart-pie text-yellow-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Estadísticas Generales</h3>
                    <p class="text-sm text-gray-500">Métricas y análisis de participaciones</p>
                </div>
            </div>

            {{-- Tarjetas de estadísticas --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-5 text-center shadow-sm transform hover:scale-105 transition-transform duration-200">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-1">{{ $totalInscritos }}</h3>
                    <p class="text-sm opacity-90">Total Inscritos</p>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl p-5 text-center shadow-sm transform hover:scale-105 transition-transform duration-200">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-1">{{ $aprobadas }}</h3>
                    <p class="text-sm opacity-90">Aprobadas</p>
                </div>
                
                <div class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-2xl p-5 text-center shadow-sm transform hover:scale-105 transition-transform duration-200">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-1">{{ $rechazadas }}</h3>
                    <p class="text-sm opacity-90">Rechazadas</p>
                </div>
                
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-2xl p-5 text-center shadow-sm transform hover:scale-105 transition-transform duration-200">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-1">{{ $pendientes }}</h3>
                    <p class="text-sm opacity-90">Pendientes</p>
                </div>
            </div>

            {{-- Tabla de disciplinas --}}
            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h4 class="text-md font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-ol mr-2 text-blue-500"></i>
                        Inscritos por Disciplina
                    </h4>
                    <p class="text-sm text-gray-500 mt-1">Distribución de participantes en cada disciplina</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">
                                    <i class="fas fa-running mr-2 text-gray-500"></i>
                                    Disciplina
                                </th>
                                <th class="px-6 py-4 text-center font-semibold">
                                    <i class="fas fa-user-friends mr-2 text-gray-500"></i>
                                    Total Inscritos
                                </th>
                                <th class="px-6 py-4 text-center font-semibold">
                                    Porcentaje
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($porDisciplina as $item)
                                @php
                                    $porcentaje = $totalInscritos > 0 ? round(($item['inscritos'] / $totalInscritos) * 100, 1) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                            {{ $item['disciplina'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $item['inscritos'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="h-2 rounded-full bg-blue-500" style="width: {{ $porcentaje }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-600">{{ $porcentaje }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if($totalInscritos > 0)
                        <tfoot class="bg-gray-50 border-t border-gray-200">
                            <tr>
                                <td class="px-6 py-4 font-semibold text-gray-800">Total General</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-800">
                                        {{ $totalInscritos }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-gray-600">100%</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Información adicional --}}
            <div class="mt-6 flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center">
                    <i class="fas fa-sync-alt mr-2 text-blue-500"></i>
                    <span>Última actualización: {{ now()->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-database mr-2 text-green-500"></i>
                    <span>Datos en tiempo real</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Mensaje para otros roles --}}
    @if (!in_array($user->rol, ['Administrador', 'Supervisor']))
        <div class="card bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl shadow-sm p-8 text-center border border-gray-200">
            <div class="w-20 h-20 mx-auto mb-6 bg-gray-200 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-bar text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-3">Acceso Restringido</h3>
            <p class="text-gray-600 max-w-md mx-auto mb-6">
                El acceso al panel de reportes está disponible únicamente para administradores y supervisores del sistema.
            </p>
            <a href="{{ url('/') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver al Inicio
            </a>
        </div>
    @endif

</div>

<style>
.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.transition-colors {
    transition: all 0.2s ease-in-out;
}

.transform {
    transform: translateX(0) translateY(0) rotate(0) skewX(0) skewY(0) scaleX(1) scaleY(1);
}

.hover\:scale-105:hover {
    transform: scale(1.05);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection