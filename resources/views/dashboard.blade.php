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
            <p class="text-3xl font-bold text-gray-900 mt-2 transition dark:text-gray-100" id="activeStudents">
                {{ $activeStudents }}
            </p>
        </x-card>

        <!-- Docentes Activos -->
        <x-card class="border-b-[5px] border-green-500 p-6">
            <div class="flex items-center justify-between">
                <p class="text-gray-600 transition dark:text-gray-400">Docentes Activos</p>
                <div
                    class="bg-green-50 p-3 rounded-xl text-green-600 transition dark:bg-green-600/10 dark:text-green-500">
                    <x-icon-teachers />
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2 transition dark:text-gray-100" id="activeStudents">
                {{ $activeTeachers }}
            </p>
        </x-card>

        <!-- Cursos Activos -->
        <x-card class="border-b-[5px] border-orange-400 p-6">
            <div class="flex items-center justify-between">
                <p class="text-gray-600 transition dark:text-gray-400">Cursos Activos</p>
                <div
                    class="bg-orange-50 p-3 rounded-xl text-orange-600 transition dark:bg-orange-600/10 dark:text-orange-500">
                    <x-icon-courses />
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2 transition dark:text-gray-100" id="activeStudents">
                {{ $activeCourses }}
            </p>
        </x-card>

        <!-- Matrículas Totales -->
        <x-card class="border-b-[5px] border-purple-500 p-6">
            <div class="flex items-center justify-between">
                <p class="text-gray-600 transition dark:text-gray-400">Matrículas Totales</p>
                <div
                    class="bg-purple-50 p-3 rounded-xl text-purple-600 transition dark:bg-purple-600/10 dark:text-purple-500">
                    <x-icon-enrollments />
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 mt-2 transition dark:text-gray-100" id="activeStudents">
                {{ $totalEnrollments }}
            </p>
        </x-card>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Matrículas por Curso --}}
        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-4">
                    <div
                        class="bg-blue-100 p-3 rounded-xl text-blue-600 transition dark:bg-blue-600/10 dark:text-blue-500">
                        <x-icon-enrollments />
                    </div>
                    <p class="text-gray-600 font-medium text-lg transition dark:text-gray-100">Matrículas por Curso</p>
                </div>
            </x-slot>
            <div class="p-5">
                <x-chartjs-component :chart="$enrollmentChart" />
            </div>
        </x-card>

        {{-- Distribución de alumnos --}}
        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-4">
                    <div
                        class="bg-green-100 p-3 rounded-xl text-green-600 transition dark:bg-green-600/10 dark:text-green-500">
                        <x-icon-students />
                    </div>
                    <p class="text-gray-600 font-medium text-lg transition dark:text-gray-100">Distribución de Alumnos
                    </p>
                </div>
            </x-slot>
            <div class="p-5 w-[400px] mx-auto">
                <x-chartjs-component :chart="$distributionChart" />
            </div>
        </x-card>

        {{-- Promedio de Calificaciones --}}
        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-4">
                    <div
                        class="bg-orange-100 p-3 rounded-xl text-orange-600 transition dark:bg-orange-600/10 dark:text-orange-500">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 22H22" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9.75 4V22H14.25V4C14.25 2.9 13.8 2 12.45 2H11.55C10.2 2 9.75 2.9 9.75 4Z"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M3 10V22H7V10C7 8.9 6.6 8 5.4 8H4.6C3.4 8 3 8.9 3 10Z" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17 15V22H21V15C21 13.9 20.6 13 19.4 13H18.6C17.4 13 17 13.9 17 15Z"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </div>
                    <p class="text-gray-600 font-medium text-lg transition dark:text-gray-100">Docentes con más carga</p>
                </div>
            </x-slot>
            <div class="p-5">
                <x-chartjs-component :chart="$teacherChart" />
            </div>
        </x-card>

        {{-- Tendencia de Matrículas --}}
        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-4">
                    <div
                        class="bg-purple-100 p-3 rounded-xl text-purple-600 transition dark:bg-purple-600/10 dark:text-purple-500">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 2V19C2 20.66 3.34 22 5 22H22" stroke="currentColor" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M5 17L9.59 11.64C10.35 10.76 11.7 10.7 12.52 11.53L13.47 12.48C14.29 13.3 15.64 13.25 16.4 12.37L21 7"
                                stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                    </div>
                    <p class="text-gray-600 font-medium text-lg transition dark:text-gray-100">Tendencia de Matrículas
                    </p>
                </div>
            </x-slot>
            <div class="p-5">
                <x-chartjs-component :chart="$monthlyEnrollmentsChart" />
            </div>
        </x-card>
    </div>
</x-app-layout>
