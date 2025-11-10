@extends('layouts.base')

@section('title', 'Disciplinas Disponibles')
@section('page-title', 'Disciplinas Deportivas y Culturales')
@section('page-subtitle', 'Selecciona hasta 2 disciplinas para participar')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- ESTO ES PARA QUE NO PUEDA ESCOGER LAS DISCIPLINAS SI NO SE HA REGISTRADO --}}
        @php
            $registro = DB::table('participantes')
                ->where('user_id', Auth::user()->id)
                ->whereNull('deleted_at')
                ->first();
        @endphp


        @if ($registro)
            <!-- Información del participante -->
            <div class="card bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Hola, {{ Auth::user()->name }}</h3>
                        <p class="text-gray-600">Selecciona las disciplinas en las que deseas participar</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Disciplinas seleccionadas</p>
                        <p class="text-xl font-bold text-blue-600" id="contador-disciplinas">0/2</p>
                    </div>
                </div>
            </div>

            <!-- Disciplinas Disponibles -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Disciplina 1 -->
                <div class="card bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Fútbol 7 Varonil</h3>
                            <p class="text-sm text-gray-500">Deportivo</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-blue-500 flex items-center justify-center text-white">
                            <i class="fas fa-futbol text-xl"></i>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4">Fútbol 7 para participantes masculinos. Requiere condición física
                        básica.</p>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Cupo</p>
                            <p class="text-sm font-medium text-gray-800">32 / 50</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estado</p>
                            <p class="text-sm font-medium text-green-600">Disponible</p>
                        </div>
                    </div>

                    <button type="button" class="w-full btn bg-gray-200 text-gray-700 hover:bg-gray-300 toggle-disciplina">
                        <i class="fas fa-plus mr-2"></i>Seleccionar
                    </button>
                </div>

                <!-- Disciplina 2 -->
                <div class="card bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Básquetbol Varonil</h3>
                            <p class="text-sm text-gray-500">Deportivo</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-green-500 flex items-center justify-center text-white">
                            <i class="fas fa-basketball-ball text-xl"></i>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4">Básquetbol tradicional para participantes masculinos.</p>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Cupo</p>
                            <p class="text-sm font-medium text-gray-800">28 / 40</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estado</p>
                            <p class="text-sm font-medium text-green-600">Disponible</p>
                        </div>
                    </div>

                    <button type="button" class="w-full btn bg-gray-200 text-gray-700 hover:bg-gray-300 toggle-disciplina">
                        <i class="fas fa-plus mr-2"></i>Seleccionar
                    </button>
                </div>

                <!-- Disciplina 3 -->
                <div class="card bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Ajedrez</h3>
                            <p class="text-sm text-gray-500">Cultural</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-purple-500 flex items-center justify-center text-white">
                            <i class="fas fa-chess text-xl"></i>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4">Competencia de ajedrez por eliminación directa.</p>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Cupo</p>
                            <p class="text-sm font-medium text-gray-800">15 / 30</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estado</p>
                            <p class="text-sm font-medium text-green-600">Disponible</p>
                        </div>
                    </div>

                    <button type="button" class="w-full btn bg-gray-200 text-gray-700 hover:bg-gray-300 toggle-disciplina">
                        <i class="fas fa-plus mr-2"></i>Seleccionar
                    </button>
                </div>

                <!-- Disciplina 4 -->
                <div class="card bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Voleibol Femenil</h3>
                            <p class="text-sm text-gray-500">Deportivo</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-yellow-500 flex items-center justify-center text-white">
                            <i class="fas fa-volleyball-ball text-xl"></i>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4">Voleibol para participantes femeninas.</p>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Cupo</p>
                            <p class="text-sm font-medium text-gray-800">38 / 40</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estado</p>
                            <p class="text-sm font-medium text-red-600">Casi lleno</p>
                        </div>
                    </div>

                    <button type="button" class="w-full btn bg-gray-200 text-gray-700 hover:bg-gray-300 toggle-disciplina">
                        <i class="fas fa-plus mr-2"></i>Seleccionar
                    </button>
                </div>

                <!-- Disciplina 5 -->
                <div class="card bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Atletismo</h3>
                            <p class="text-sm text-gray-500">Deportivo</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-red-500 flex items-center justify-center text-white">
                            <i class="fas fa-running text-xl"></i>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4">Competencia de atletismo en varias categorías.</p>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Cupo</p>
                            <p class="text-sm font-medium text-gray-800">45 / 60</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estado</p>
                            <p class="text-sm font-medium text-green-600">Disponible</p>
                        </div>
                    </div>

                    <button type="button" class="w-full btn bg-gray-200 text-gray-700 hover:bg-gray-300 toggle-disciplina">
                        <i class="fas fa-plus mr-2"></i>Seleccionar
                    </button>
                </div>

                <!-- Disciplina 6 -->
                <div class="card bg-white rounded-xl shadow-sm p-6 opacity-60">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Canto</h3>
                            <p class="text-sm text-gray-500">Cultural</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-pink-500 flex items-center justify-center text-white">
                            <i class="fas fa-music text-xl"></i>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4">Competencia de canto individual y grupal.</p>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Cupo</p>
                            <p class="text-sm font-medium text-gray-800">25 / 25</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estado</p>
                            <p class="text-sm font-medium text-red-600">Lleno</p>
                        </div>
                    </div>

                    <button type="button" class="w-full btn bg-gray-400 cursor-not-allowed" disabled>
                        <i class="fas fa-times mr-2"></i>Sin cupo
                    </button>
                </div>
            </div>

            <!-- Disciplinas Seleccionadas -->
            <div class="card bg-white rounded-xl shadow-sm p-6 mb-6" id="disciplinas-seleccionadas-container"
                style="display: none;">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Disciplinas Seleccionadas</h3>
                <div id="disciplinas-seleccionadas" class="space-y-3">
                    <!-- Las disciplinas seleccionadas aparecerán aquí -->
                </div>
            </div>

            <!-- Botón de confirmación -->
            <div class="flex justify-end space-x-4">
                <a href="{{ url('/') }}" class="btn bg-gray-300 text-gray-700 hover:bg-gray-400">
                    Cancelar
                </a>
                <button type="button" id="confirmar-inscripcion" class="btn btn-primary opacity-50 cursor-not-allowed"
                    disabled>
                    <i class="fas fa-check-circle mr-2"></i>Confirmar Inscripción
                </button>
            </div>
        @else


            <!-- Información importante si YA SE REGISTRO -->
            <div class="card bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-blue-800">Información Importante</h3>
                        <ul class="mt-2 text-blue-700 list-disc list-inside space-y-1">
                            <li>Aún no te has registrado. Registrate primero para seleccionar las disciplinas en las que deseas participar.</li>
                        </ul>
                    </div>
                </div>
            </div>



        @endif

    </div>

    <script>
        const disciplinasSeleccionadas = new Set();
        const MAX_DISCIPLINAS = 2;

        document.querySelectorAll('.toggle-disciplina').forEach(button => {
            button.addEventListener('click', function() {
                const card = this.closest('.card');
                const nombre = card.querySelector('h3').textContent;
                const categoria = card.querySelector('p.text-gray-500').textContent;

                if (disciplinasSeleccionadas.has(nombre)) {
                    // Remover disciplina
                    disciplinasSeleccionadas.delete(nombre);
                    this.classList.remove('btn-primary');
                    this.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                    this.innerHTML = '<i class="fas fa-plus mr-2"></i>Seleccionar';
                    card.classList.remove('ring-2', 'ring-blue-500');
                } else {
                    // Verificar límite
                    if (disciplinasSeleccionadas.size >= MAX_DISCIPLINAS) {
                        alert('Solo puedes seleccionar hasta ' + MAX_DISCIPLINAS + ' disciplinas');
                        return;
                    }

                    // Agregar disciplina
                    disciplinasSeleccionadas.add(nombre);
                    this.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                    this.classList.add('btn-primary');
                    this.innerHTML = '<i class="fas fa-check mr-2"></i>Seleccionada';
                    card.classList.add('ring-2', 'ring-blue-500');
                }

                actualizarInterfaz();
            });
        });

        function actualizarInterfaz() {
            // Actualizar contador
            document.getElementById('contador-disciplinas').textContent =
                disciplinasSeleccionadas.size + '/' + MAX_DISCIPLINAS;

            // Actualizar botón de confirmación
            const btnConfirmar = document.getElementById('confirmar-inscripcion');
            if (disciplinasSeleccionadas.size > 0) {
                btnConfirmar.classList.remove('opacity-50', 'cursor-not-allowed');
                btnConfirmar.disabled = false;
            } else {
                btnConfirmar.classList.add('opacity-50', 'cursor-not-allowed');
                btnConfirmar.disabled = true;
            }

            // Actualizar lista de disciplinas seleccionadas
            actualizarListaSeleccionadas();
        }

        function actualizarListaSeleccionadas() {
            const container = document.getElementById('disciplinas-seleccionadas-container');
            const lista = document.getElementById('disciplinas-seleccionadas');

            if (disciplinasSeleccionadas.size > 0) {
                container.style.display = 'block';
                lista.innerHTML = '';

                disciplinasSeleccionadas.forEach(nombre => {
                    lista.innerHTML += `
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">${nombre}</p>
                            <p class="text-sm text-gray-600">Disciplina seleccionada</p>
                        </div>
                        <button type="button" class="text-red-500 hover:text-red-700 quitar-disciplina" data-nombre="${nombre}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                });

                // Agregar event listeners a los botones de quitar
                document.querySelectorAll('.quitar-disciplina').forEach(button => {
                    button.addEventListener('click', function() {
                        const nombre = this.dataset.nombre;
                        disciplinasSeleccionadas.delete(nombre);

                        // Buscar el botón original y actualizarlo
                        document.querySelectorAll('.card').forEach(card => {
                            const cardNombre = card.querySelector('h3').textContent;
                            if (cardNombre === nombre) {
                                const btnOriginal = card.querySelector('.toggle-disciplina');
                                btnOriginal.classList.remove('btn-primary');
                                btnOriginal.classList.add('bg-gray-200', 'text-gray-700',
                                    'hover:bg-gray-300');
                                btnOriginal.innerHTML =
                                    '<i class="fas fa-plus mr-2"></i>Seleccionar';
                                card.classList.remove('ring-2', 'ring-blue-500');
                            }
                        });

                        actualizarInterfaz();
                    });
                });
            } else {
                container.style.display = 'none';
            }
        }

        // Confirmar inscripción
        document.getElementById('confirmar-inscripcion').addEventListener('click', function() {
            if (disciplinasSeleccionadas.size === 0) return;

            const disciplinasList = Array.from(disciplinasSeleccionadas).join(', ');
            alert(
                `Inscripción confirmada en: ${disciplinasList}\n\nEsta es una demostración. En un sistema real se guardaría en la base de datos.`);

            // Redirigir al dashboard
            window.location.href = "{{ url('/') }}";
        });
    </script>
@endsection
