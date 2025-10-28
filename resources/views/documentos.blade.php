@extends('layouts.app')

@section('title', 'Gestión de Documentos')
@section('page-title', 'Gestión de Documentos')
@section('page-subtitle', 'Sube y gestiona tus documentos')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Estado de documentos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-file-upload text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Por Subir</p>
                    <h3 class="text-2xl font-bold text-gray-800">2</h3>
                </div>
            </div>
        </div>
        
        <div class="card bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">En Revisión</p>
                    <h3 class="text-2xl font-bold text-gray-800">1</h3>
                </div>
            </div>
        </div>
        
        <div class="card bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Aprobados</p>
                    <h3 class="text-2xl font-bold text-gray-800">3</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de subida de documentos -->
    <div class="card bg-white rounded-xl shadow-sm p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Subir Nuevos Documentos</h2>
        
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tipo de Documento -->
                <div>
                    <label for="tipo_documento" class="form-label">Tipo de Documento *</label>
                    <select id="tipo_documento" name="tipo_documento" class="form-input" required>
                        <option value="">Selecciona un tipo</option>
                        <option value="constancia_laboral">Constancia Laboral</option>
                        <option value="comprobante_pago">CFDI/Recibo de Nómina</option>
                        <option value="identificacion">Identificación Oficial</option>
                        <option value="fotografia">Fotografía Actualizada</option>
                        <option value="otro">Otro Documento</option>
                    </select>
                </div>

                <!-- Fecha de Expedición -->
                <div>
                    <label for="fecha_expedicion" class="form-label">Fecha de Expedición</label>
                    <input type="date" id="fecha_expedicion" name="fecha_expedicion" class="form-input">
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="form-label">Descripción del Documento</label>
                <textarea id="descripcion" name="descripcion" rows="3" 
                          class="form-input" placeholder="Describe el contenido del documento..."></textarea>
            </div>

            <!-- Archivo -->
            <div>
                <label for="archivo" class="form-label">Archivo *</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                    <div class="space-y-1 text-center">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl"></i>
                        <div class="flex text-sm text-gray-600">
                            <label for="archivo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Sube un archivo</span>
                                <input id="archivo" name="archivo" type="file" class="sr-only" required>
                            </label>
                            <p class="pl-1">o arrastra y suelta</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF, JPG, PNG hasta 5MB</p>
                    </div>
                </div>
                <div id="nombre-archivo" class="mt-2 text-sm text-gray-600 hidden"></div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-4">
                <button type="reset" class="btn bg-gray-300 text-gray-700 hover:bg-gray-400">
                    Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload mr-2"></i>Subir Documento
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de documentos subidos -->
    <div class="card bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Mis Documentos</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Documento
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha Subida
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Documento 1 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        constancia_laboral.pdf
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        150 KB
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Constancia Laboral
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            15/01/2024 10:30
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i> Aprobado
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="#" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Documento 2 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                                        <i class="fas fa-file-image"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        comprobante_pago.jpg
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        200 KB
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                CFDI/Recibo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            16/01/2024 14:20
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i> En Revisión
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="#" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Documento 3 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600">
                                        <i class="fas fa-file-image"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        fotografia.png
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        180 KB
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                Fotografía
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            14/01/2024 09:15
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i> Aprobado
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="#" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Mostrar nombre del archivo seleccionado
    document.getElementById('archivo').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileNameElement = document.getElementById('nombre-archivo');
        
        if (fileName) {
            fileNameElement.textContent = 'Archivo seleccionado: ' + fileName;
            fileNameElement.classList.remove('hidden');
        } else {
            fileNameElement.classList.add('hidden');
        }
    });

    // Simular subida de archivo
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Documento subido correctamente (simulación)\n\nEn un sistema real, el archivo se guardaría en el servidor.');
        this.reset();
        document.getElementById('nombre-archivo').classList.add('hidden');
    });
</script>
@endsection