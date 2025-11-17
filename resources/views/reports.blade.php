<x-app-layout>
    <!-- Header -->
    <header>
        <h1 class="text-3xl font-semibold text-gray-800 mb-2 transition dark:text-gray-100 ">Reportes</h1>
        <p class="text-gray-500 transition dark:text-gray-400">Genera y exporta reportes del sistema</p>
    </header>

    <section class="flex-1">
        {{-- Alpine.js para la funcionalidad de pestañas --}}
        <div x-data="{ activeTab: 'alumnos' }" class="mb-6">
            {{-- Tabs --}}
            <div class="flex space-x-2">
                <button @click="activeTab = 'alumnos'"
                    :class="{ 'bg-gray-200 text-gray-700': activeTab === 'alumnos', 'text-gray-600 hover:bg-gray-200': activeTab !== 'alumnos' }"
                    class="px-4 py-2 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-[#165EFB] transition duration-200">
                    Alumnos
                </button>
                <button @click="activeTab = 'cursos'"
                    :class="{ 'bg-gray-200 text-gray-700': activeTab === 'cursos', 'text-gray-600 hover:bg-gray-200': activeTab !== 'cursos' }"
                    class="px-4 py-2 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-[#165EFB] transition duration-200">
                    Cursos
                </button>
                <button @click="activeTab = 'docentes'"
                    :class="{ 'bg-gray-200 text-gray-700': activeTab === 'docentes', 'text-gray-600 hover:bg-gray-200': activeTab !== 'docentes' }"
                    class="px-4 py-2 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-[#165EFB] transition duration-200">
                    Docentes
                </button>
            </div>

            {{-- Contenido de las pestañas --}}
            <div class="mt-6">
                {{-- Pestaña de Alumnos --}}
                <x-card x-show="activeTab === 'alumnos'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <x-slot name="header">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-medium text-gray-800 dark:text-gray-100">Reporte de Alumnos</h2>
                            <x-primary-button>
                                Exportar CSV (Alumnos)
                            </x-primary-button>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 uppercase tracking-wider text-xs   dark:bg-gray-900/10">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left font-medium">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left font-medium">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left font-medium">
                                        Teléfono
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left font-medium">
                                        Estado
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left font-medium">
                                        Cursos Completados
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left font-medium">
                                        Cursos Matriculados
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left font-medium">
                                        Promedio
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs">
                                        Daniel Eduardo Villofranqui Colquicacha
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        1505049@senati.pe
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        +51 910 883 895
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        activo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        0
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        2
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600">
                                        16.00
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs">
                                        Carlos Alberto Ramírez Villegas
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        1548942@senati.pe
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        +51 954 654 604
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        activo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        1
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        3
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-red-600">
                                        10.00
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs">
                                        Jossue Andres Huayapa Julca
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        1546792@senati.pe
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        +51 935 456 489
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        activo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        0
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        2
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600">
                                        18.00
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </x-card>

                {{-- Pestaña de Cursos --}}
                <div x-show="activeTab === 'cursos'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Reporte de Cursos</h2>
                        <button
                            class="flex items-center px-4 py-2 bg-[#165EFB] text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m-3 6H9a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v7a2 2 0 01-2 2h-1">
                                </path>
                            </svg>
                            Exportar CSV (Cursos)
                        </button>
                    </div>
                    <p class="text-gray-600">Aquí se mostraría la tabla de reportes de cursos.</p>
                    {{-- Aquí iría la tabla de cursos con sus datos --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre del Curso
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Código
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Docente Asignado
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Alumnos Inscritos
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                <div x-show="activeTab === 'docentes'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Reporte de Docentes</h2>
                        <button
                            class="flex items-center px-4 py-2 bg-[#165EFB] text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m-3 6H9a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v7a2 2 0 01-2 2h-1">
                                </path>
                            </svg>
                            Exportar CSV (Docentes)
                        </button>
                    </div>
                    <p class="text-gray-600">Aquí se mostraría la tabla de reportes de docentes.</p>
                    {{-- Aquí iría la tabla de docentes con sus datos --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre Completo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Especialidad
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cursos Asignados
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
    </section>
</x-app-layout>
