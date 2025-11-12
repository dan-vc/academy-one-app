<x-app-layout>
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl text-slate-800 font-semibold mb-2">Gestión de Alumnos</h1>
            <p class="text-slate-500">Administra la información de los estudiantes</p>
        </div>

        <x-primary-button>
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Alumno
        </x-primary-button>
    </div>

    <!-- Card with Table -->
    <div class="bg-white rounded-2xl overflow-hidden border-0 shadow-lg">
        <!-- Card Header -->
        <div class="border-b bg-slate-100 p-6 pb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                        <x-icon-students />
                    </div>
                    <h3 class="text-xl font-medium text-slate-800">Lista de Alumnos</h3>
                </div>
                <div class="px-4 py-2 bg-blue-100 rounded-lg">
                    <p class="text-blue-600 font-medium">
                        Total: <span id="studentCount">0</span> estudiantes
                    </p>
                </div>
            </div>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 h-5 w-5" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchInput" placeholder="Buscar por nombre, apellido o email..."
                    oninput="filterStudents()"
                    class="w-full pl-11 h-12 border border-slate-200 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-300 transition-colors" />
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200">
                        <th class="text-left px-6 py-4 text-sm font-medium text-slate-700">Nombre</th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-slate-700">Código</th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-slate-700">Email</th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-slate-700">Teléfono</th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-slate-700">Semestre</th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-slate-700">Fecha de Matriculación</th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-slate-700">Estado</th>
                        <th class="text-right px-6 py-4 text-sm font-medium text-slate-700">Acciones</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody" class="text-slate-500">
                    <!-- Rows will be inserted here -->
                    <tr class="border-b border-slate-200 hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-800">
                            Daniel Eduardo Villafranqui
                        </td>
                        <td class="px-6 py-4">
                            001505049
                        </td>
                        <td class="px-6 py-4">
                            carlosrv@example.com
                        </td>
                        <td class="px-6 py-4 ">
                            +51 912 345 678
                        </td>
                        <td class="px-6 py-4">
                            VI
                        </td>
                        <td class="px-6 py-4">
                            31/8/2024
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-2 bg-green-100 rounded-lg text-green-600">
                                activo
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-800">
                            <div class="flex justify-end gap-2">
                                <button onclick="editStudent('${student.id}')"
                                    class="inline-flex items-center p-2 border border-slate-300 rounded-lg hover:bg-blue-100 hover:text-blue-600 hover:border-blue-400 transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button onclick="deleteStudent('${student.id}')"
                                    class="inline-flex items-center p-2 border border-slate-300 rounded-lg hover:bg-red-100 hover:text-red-600 hover:border-red-400 transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
