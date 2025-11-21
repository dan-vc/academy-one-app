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
                    :class="{ 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-100': activeTab === 'alumnos', 'text-gray-600 hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-gray-400': activeTab !== 'alumnos' }"
                    class="px-4 py-2 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-[#165EFB] transition duration-200">
                    Alumnos
                </button>
                <button @click="activeTab = 'cursos'"
                    :class="{ 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-100': activeTab === 'cursos', 'text-gray-600 hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-gray-400': activeTab !== 'cursos' }"
                    class="px-4 py-2 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-[#165EFB] transition duration-200">
                    Cursos
                </button>
                <button @click="activeTab = 'docentes'"
                    :class="{ 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-100': activeTab === 'docentes', 'text-gray-600 hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-gray-400': activeTab !== 'docentes' }"
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
                            <x-primary-button href="{{ route('reports.students.export') }}">
                                Exportar CSV (Alumnos)
                            </x-primary-button>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 uppercase tracking-wider text-xs   dark:bg-gray-900/10">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Teléfono
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Estado
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Cursos Completados
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Cursos Matriculados
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Promedio
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($students as $student)
                                    <tr>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs">
                                            {{ $student->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $student->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $student->phone }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $student->deleted_at ? 'inactivo' : 'activo' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $student->approved_courses_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $student->enrolled_courses_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-green-600">
                                            16.00
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>

                {{-- Pestaña de Cursos --}}
                <x-card x-show="activeTab === 'cursos'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <x-slot name="header">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-medium text-gray-800 dark:text-gray-100">Reporte de Cursos</h2>
                            <x-primary-button href="{{ route('reports.courses.export') }}">
                                Exportar CSV (Cursos)
                            </x-primary-button>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 uppercase tracking-wider text-xs   dark:bg-gray-900/10">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Nombre del curso
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Código
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Docente Asignado
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Matriculados/Capacidad
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Ocupación
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Promedio
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Tasa de Aprobación
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($courses as $course)
                                    <tr>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs">
                                            {{ $course->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $course->course_code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $course->teacher->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $course->total_students }} / {{ $course->max_capacity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $course->occupationRate() }}%
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-green-600">
                                            16.00
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($course->approvalRate() < 50)
                                                <span class="text-red-600 font-semibold">
                                                    {{ $course->approvalRate() }}%
                                                </span>
                                            @else
                                                <span class="text-green-600 font-semibold">
                                                    {{ $course->approvalRate() }}%
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>

                {{-- Pestaña de Docentes --}}
                <x-card x-show="activeTab === 'docentes'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <x-slot name="header">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-medium text-gray-800 dark:text-gray-100">Reporte de Docentes</h2>
                            <x-primary-button href="{{ route('reports.teachers.export') }}">
                                Exportar CSV (Docentes)
                            </x-primary-button>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 uppercase tracking-wider text-xs   dark:bg-gray-900/10">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Nombre Completo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Código
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        DNI/C.E.
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Título Profesional
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Fecha de Ingreso
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left font-medium">
                                        Cursos Activos
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs">
                                            {{ $teacher->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $teacher->teacher_code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $teacher->dni }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $teacher->profession }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $teacher->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-green-600">
                                            {{ $teacher->active_courses_count }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>
        </div>
    </section>
</x-app-layout>
