<x-app-layout>
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold text-gray-800 mb-2 transition dark:text-gray-100 ">Dashboard</h1>
        <p class="text-gray-500 transition dark:text-gray-400">Resumen general del sistema académico</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Alumnos Activos -->
        <x-card class="border-b-[5px] border-blue-600 p-6">
            <div class="flex items-center justify-between">
                <p class="text-gray-600 transition dark:text-gray-400">Alumnos Activos</p>
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600 transition dark:bg-blue-600/10 dark:text-blue-500">
                    <x-icon-students />
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2 transition dark:text-gray-100" id="activeStudents">0</p>
        </x-card>

        <!-- Docentes Activos -->
        <x-card class="border-b-[5px] border-green-500 p-6">
            <div class="flex items-center justify-between">
                <p class="text-gray-600 transition dark:text-gray-400">Docentes Activos</p>
                <div class="bg-green-50 p-3 rounded-xl text-green-600 transition dark:bg-green-600/10 dark:text-green-500">
                    <x-icon-teachers />
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2 transition dark:text-gray-100" id="activeStudents">0</p>
        </x-card>

        <!-- Cursos Activos -->
        <x-card class="border-b-[5px] border-orange-400 p-6">
            <div class="flex items-center justify-between">
                <p class="text-gray-600 transition dark:text-gray-400">Cursos Activos</p>
                <div class="bg-orange-50 p-3 rounded-xl text-orange-600 transition dark:bg-orange-600/10 dark:text-orange-500">
                    <x-icon-courses />
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2 transition dark:text-gray-100" id="activeStudents">0</p>
        </x-card>

        <!-- Matrículas Totales -->
        <x-card class="border-b-[5px] border-purple-500 p-6">
            <div class="flex items-center justify-between">
                <p class="text-gray-600 transition dark:text-gray-400">Matrículas Totales</p>
                <div class="bg-purple-50 p-3 rounded-xl text-purple-600 transition dark:bg-purple-600/10 dark:text-purple-500">
                    <x-icon-enrollments />
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2 transition dark:text-gray-100" id="activeStudents">0</p>
        </x-card>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Matrículas por Curso --}}
        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-xl text-blue-600 transition dark:bg-blue-600/10 dark:text-blue-500">
                        <x-icon-enrollments />
                    </div>
                    <p class="text-gray-600 font-medium text-lg transition dark:text-gray-100">Matrículas por Curso</p>
                </div>
            </x-slot>
            <div class="p-5">
                <x-chartjs-component :chart="$chart" />
            </div>
        </x-card>

        {{-- Distribución de alumnos --}}
        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-xl text-blue-600 transition dark:bg-blue-600/10 dark:text-blue-500">
                        <x-icon-enrollments />
                    </div>
                    <p class="text-gray-600 font-medium text-lg transition dark:text-gray-100">Matrículas por Curso</p>
                </div>
            </x-slot>
            <div class="p-5">
                <x-chartjs-component :chart="$chart" />
            </div>
        </x-card>

        {{-- Promedio de Calificaciones --}}
        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-xl text-blue-600 transition dark:bg-blue-600/10 dark:text-blue-500">
                        <x-icon-enrollments />
                    </div>
                    <p class="text-gray-600 font-medium text-lg transition dark:text-gray-100">Matrículas por Curso</p>
                </div>
            </x-slot>
            <div class="p-5">
                <x-chartjs-component :chart="$chart" />
            </div>
        </x-card>

        {{-- Tendencia de Matrículas --}}
        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-xl text-blue-600 transition dark:bg-blue-600/10 dark:text-blue-500">
                        <x-icon-enrollments />
                    </div>
                    <p class="text-gray-600 font-medium text-lg transition dark:text-gray-100">Matrículas por Curso</p>
                </div>
            </x-slot>
            <div class="p-5">
                <x-chartjs-component :chart="$chart" />
            </div>
        </x-card>
    </div>
</x-app-layout>
