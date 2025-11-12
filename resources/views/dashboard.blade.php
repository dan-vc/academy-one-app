<x-app-layout>
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold text-slate-800 mb-2">Dashboard</h1>
        <p class="text-slate-500">Resumen general del sistema académico</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Alumnos Activos -->
        <x-card class="border-b-[5px] border-blue-600 p-6">
            <div class="flex items-center justify-between">
                <p class="text-slate-600">Alumnos Activos</p>
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                    <x-icon-students />
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-2" id="activeStudents">0</p>
        </x-card>

        <!-- Docentes Activos -->
        <x-card class="border-b-[5px] border-green-500 p-6">
            <div class="flex items-center justify-between">
                <p class="text-slate-600">Docentes Activos</p>
                <div class="bg-green-50 p-3 rounded-xl text-green-600">
                    <x-icon-teachers />
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-2" id="activeStudents">0</p>
        </x-card>

        <!-- Cursos Activos -->
        <x-card class="border-b-[5px] border-orange-400 p-6">
            <div class="flex items-center justify-between">
                <p class="text-slate-600">Cursos Activos</p>
                <div class="bg-orange-50 p-3 rounded-xl text-orange-600">
                    <x-icon-courses />
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-2" id="activeStudents">0</p>
        </x-card>

        <!-- Matrículas Totales -->
        <x-card class="border-b-[5px] border-purple-500 p-6">
            <div class="flex items-center justify-between">
                <p class="text-slate-600">Matrículas Totales</p>
                <div class="bg-purple-50 p-3 rounded-xl text-purple-600">
                    <x-icon-enrollments />
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-900 mt-2" id="activeStudents">0</p>
        </x-card>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Enrollments per Course -->
        <x-card>
            <x-slot name="header">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 p-3 rounded-xl text-blue-600">
                        <x-icon-enrollments />
                    </div>
                    <p class="text-slate-600 font-medium text-lg">Matrículas por Curso</p>
                </div>
            </x-slot>
            <div class="h-[300px]">
                <canvas id="enrollmentsChart"></canvas>
            </div>
        </x-card>

        <!-- Students by Status -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Distribución de Alumnos</h3>
                <div class="h-[300px]">
                    <canvas id="studentsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Average Grades -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Promedio de Calificaciones</h3>
                <div class="h-[300px]">
                    <canvas id="gradesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Monthly Trend -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Tendencia de Matrículas</h3>
                <div class="h-[300px]">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
