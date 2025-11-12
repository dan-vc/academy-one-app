<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <div class="w-64 bg-[#141E30] text-white flex flex-col">
            <div class="p-4 border-b border-gray-700">
                <h1 class="text-xl font-semibold">Sistema Académico</h1>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2">
                <a href="#" class="flex items-center p-2 text-gray-300 hover:bg-[#165EFB] rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center p-2 text-gray-300 hover:bg-[#165EFB] rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354l-4.243 4.243A1 1 0 007 9.54V19a1 1 0 001 1h8a1 1 0 001-1V9.54a1 1 0 00-.293-.707L12 4.354z"></path></svg>
                    Alumnos
                </a>
                <a href="#" class="flex items-center p-2 text-gray-300 hover:bg-[#165EFB] rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Docentes
                </a>
                <a href="#" class="flex items-center p-2 text-gray-300 hover:bg-[#165EFB] rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.59 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Cursos
                </a>
                <a href="#" class="flex items-center p-2 text-gray-300 hover:bg-[#165EFB] rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Matrículas
                </a>
                <a href="#" class="flex items-center p-2 bg-[#165EFB] text-white rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4m-3 0V9a2 2 0 012-2h2a2 2 0 012 2v8m-7 0v-2a2 2 0 012-2h2a2 2 0 012 2v2m-3 4h6a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Reportes
                </a>
            </nav>
            <div class="mt-auto p-4 text-center border-t border-gray-700">
                <div class="text-gray-300 text-sm">IE</div>
                <div class="text-gray-400 text-xs">Instituto Educativo</div>
                <div class="text-gray-500 text-xs">1.0.0</div>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between p-4 bg-white border-b shadow-sm">
                <div class="text-lg font-semibold text-gray-800">Reportes</div>
                <div class="text-gray-600">Genera y exporta reportes del sistema</div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    {{-- Alpine.js para la funcionalidad de pestañas --}}
                    <div x-data="{ activeTab: 'alumnos' }" class="mb-6">
                        <div class="flex space-x-2">
                            <button
                                @click="activeTab = 'alumnos'"
                                :class="{ 'bg-gray-200 text-gray-700': activeTab === 'alumnos', 'text-gray-600 hover:bg-gray-200': activeTab !== 'alumnos' }"
                                class="px-4 py-2 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-[#165EFB] transition duration-200"
                            >
                                Alumnos
                            </button>
                            <button
                                @click="activeTab = 'cursos'"
                                :class="{ 'bg-gray-200 text-gray-700': activeTab === 'cursos', 'text-gray-600 hover:bg-gray-200': activeTab !== 'cursos' }"
                                class="px-4 py-2 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-[#165EFB] transition duration-200"
                            >
                                Cursos
                            </button>
                            <button
                                @click="activeTab = 'docentes'"
                                :class="{ 'bg-gray-200 text-gray-700': activeTab === 'docentes', 'text-gray-600 hover:bg-gray-200': activeTab !== 'docentes' }"
                                class="px-4 py-2 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-[#165EFB] transition duration-200"
                            >
                                Docentes
                            </button>
                        </div>

                        {{-- Contenido de las pestañas --}}
                        <div class="mt-6 bg-white shadow-md rounded-lg p-6">
                            {{-- Pestaña de Alumnos --}}
                            <div x-show="activeTab === 'alumnos'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800">Reporte de Alumnos</h2>
                                    <button class="flex items-center px-4 py-2 bg-[#165EFB] text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m-3 6H9a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v7a2 2 0 01-2 2h-1"></path></svg>
                                        Exportar CSV (Alumnos)
                                    </button>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Email
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Teléfono
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Estado
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Cursos Completados
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Cursos Matriculados
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Promedio
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Daniel Eduardo Villofranqui Colquicacha
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    1505049@senati.pe
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    +51 910 883 895
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    activo
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    0
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    2
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                                    16.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Carlos Alberto Ramírez Villegas
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    1548942@senati.pe
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    +51 954 654 604
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    activo
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    1
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    3
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                                                    10.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Jossue Andres Huayapa Julca
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    1546792@senati.pe
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    +51 935 456 489
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    activo
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    0
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    2
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                                    18.00
                                                </td>
                                            </tr>
                                            </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Pestaña de Cursos --}}
                            <div x-show="activeTab === 'cursos'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800">Reporte de Cursos</h2>
                                    <button class="flex items-center px-4 py-2 bg-[#165EFB] text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m-3 6H9a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v7a2 2 0 01-2 2h-1"></path></svg>
                                        Exportar CSV (Cursos)
                                    </button>
                                </div>
                                <p class="text-gray-600">Aquí se mostraría la tabla de reportes de cursos.</p>
                                {{-- Aquí iría la tabla de cursos con sus datos --}}
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nombre del Curso
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Código
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Docente Asignado
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Alumnos Inscritos
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Promedio General
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Introducción a la Programación
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    PRG001
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Lic. Ana García
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    35
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                                    15.50
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Matemáticas Avanzadas
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    MAT102
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Dr. Luis Pérez
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    28
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                                    14.20
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Pestaña de Docentes --}}
                            <div x-show="activeTab === 'docentes'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800">Reporte de Docentes</h2>
                                    <button class="flex items-center px-4 py-2 bg-[#165EFB] text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m-3 6H9a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v7a2 2 0 01-2 2h-1"></path></svg>
                                        Exportar CSV (Docentes)
                                    </button>
                                </div>
                                <p class="text-gray-600">Aquí se mostraría la tabla de reportes de docentes.</p>
                                {{-- Aquí iría la tabla de docentes con sus datos --}}
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nombre Completo
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Email
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Especialidad
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Cursos Asignados
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Antigüedad
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Lic. Ana García
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    ana.garcia@instituto.com
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Programación
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    3
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    5 años
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Dr. Luis Pérez
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    luis.perez@instituto.com
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Matemáticas
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    2
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    8 años
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>