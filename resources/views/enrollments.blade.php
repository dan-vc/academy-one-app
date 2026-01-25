<x-app-layout>
    <div class="flex flex-col gap-6 sm:flex-row justify-between items-start">
        <div>
            <h1 class="text-3xl text-gray-800 font-semibold mb-2 dark:text-gray-100">Gestión de Matrículas</h1>
            <p class="text-gray-500 dark:text-gray-400">Administra la información de las matrículas de los alumnos</p>
        </div>

        <x-primary-button x-data x-on:click="$dispatch('open-modal', 'create-new-enrollment')">
            <x-icon-add />
            Nueva Matrícula
        </x-primary-button>
    </div>

    <x-card x-data="{ selected: null }">
        <x-slot name="header">
            <div class="flex flex-col gap-5 sm:items-center justify-between mb-4 sm:flex-row">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-purple-100 text-purple-600 rounded-xl dark:bg-purple-600/10">
                        <x-icon-enrollments />
                    </div>
                    <h3 class="text-xl font-medium text-gray-800 dark:text-gray-100">Lista de Matrículas</h3>
                </div>
                <div class="px-4 py-2 bg-purple-100 rounded-lg dark:bg-purple-600/10">
                    <p class="text-purple-600 font-medium dark:text-purple-500">
                        Total: <span id="enrollmentCount">{{ $enrollments->total() }}</span> matrículas
                    </p>
                </div>
            </div>
            <x-search-input class="w-full" placeholder="Buscar por alumno o docente..." />
        </x-slot>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 uppercase tracking-wider text-xs dark:bg-gray-900/10">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium">Alumno
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Curso
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Periodo
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Fecha de
                            Matrícula
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Estado
                        </th>
                        <th class="text-right px-6 py-3 font-medium">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700">
                    @foreach ($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-gray-900/50">
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs"
                                title="{{ $enrollment->student?->name }}">
                                {{ $enrollment->student->name }} {{ $enrollment->student->lastname }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs"
                                title="{{ $enrollment->course->name }}">
                                {{ $enrollment->course->name }} ({{ $enrollment->course->course_code }})
                            </td>
                            <td class="px-6 py-4" title="{{ $enrollment->period }}">
                                {{ $enrollment->period }}
                            </td>
                            <td class="px-6 py-4" title="{{ $enrollment->enrollment_date->format('d/m/Y') }}">
                                {{ $enrollment->enrollment_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{-- Lógica de etiquetas basada en el estado de la matrícula --}}
                                @php
                                    $statusClass = [
                                        'enrolled' =>
                                            'bg-blue-100 text-blue-600 dark:bg-blue-600/10 dark:text-blue-500',
                                        'retired' =>
                                            'bg-orange-100 text-orange-600 dark:bg-orange-600/10 dark:text-orange-500',
                                        'approved' =>
                                            'bg-green-100 text-green-600 dark:bg-green-600/10 dark:text-green-500',
                                        'failed' => 'bg-red-100 text-red-600 dark:bg-red-600/10 dark:text-red-500',
                                    ];
                                    $statusText = [
                                        'enrolled' => 'Matriculado',
                                        'retired' => 'Retirado',
                                        'approved' => 'Aprobado',
                                        'failed' => 'Reprobado',
                                    ];
                                @endphp
                                <span class="px-3 py-2 rounded-lg {{ $statusClass[$enrollment->status] }}">
                                    {{ $statusText[$enrollment->status] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-800 dark:text-gray-100">
                                <div class="flex justify-end gap-2">
                                    <button x-data
                                        x-on:click="$dispatch('open-modal', 'edit-enrollment'); selected = @js($enrollment);"
                                        title="Editar Matrícula"
                                        class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-blue-100 hover:text-blue-600 hover:border-blue-400 transition-colors dark:hover:bg-blue-600/10 dark:hover:text-blue-500">
                                        <x-icon-edit />
                                    </button>

                                    {{-- Botón de eliminación (puede ser condicional según el estado) --}}
                                    <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Eliminar Matrícula"
                                            onclick="return confirm('¿Seguro que deseas eliminar esta matrícula?')"
                                            class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-red-100 hover:text-red-600 hover:border-red-400 transition-colors dark:hover:bg-red-600/10 dark:hover:text-red-500">
                                            <x-icon-delete />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="py-4 px-6">
            {{ $enrollments->links() }}
        </div>

        {{-- Modal para Editar Matrícula --}}
        <x-modal name="edit-enrollment">
            <div class="p-5">
                <h2 class="text-gray-900 text-2xl font-medium mb-6 dark:text-gray-100">Editar Matrícula</h2>
                <form method="POST" :action="selected ? '{{ route('enrollments.update') }}' : '#'">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" x-bind:value="selected?.id">

                    <div>
                        <x-input-label for="edit_student_id" value="Alumno" />
                        <select id="edit_student_id" name="student_id" x-bind:value="selected?.student_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
                            required>
                            <option value="">Seleccione un alumno</option>
                            @foreach ($students as $student)
                                @if ($student->deleted_at != null)
                                    <option value="{{ $student->id }}">{{ $student->name }} {{ $student->lastname }}
                                        ({{ $student->student_code }})
                                        - INACTIVO
                                    </option>
                                @else
                                    <option value="{{ $student->id }}">{{ $student->name }} {{ $student->lastname }}
                                        ({{ $student->student_code }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="edit_course_id" value="Curso" />
                        <select id="edit_course_id" name="course_id" x-bind:value="selected?.course_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
                            required>
                            <option value="">Seleccione un curso</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}
                                    ({{ $course->course_code }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="edit_period" value="Periodo Académico" />
                        <x-text-input id="edit_period" class="block mt-1 w-full" type="text" name="period"
                            placeholder="2024-II" x-bind:value="selected?.period" required>
                            <x-icon-calendar />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('period')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="edit_enrollment_date" value="Fecha de Matrícula" />
                        <x-text-input id="edit_enrollment_date" class="block mt-1 w-full" type="date"
                            name="enrollment_date"
                            x-bind:value="selected ? new Date(selected.enrollment_date).toISOString().split('T')[0] : ''"
                            required>
                            <x-icon-calendar />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('enrollment_date')" class="mt-2" />
                    </div>


                    <div class="mt-4">
                        <x-input-label for="edit_status" value="Estado de la Matrícula" />
                        <select id="edit_status" name="status" x-bind:value="selected?.status"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
                            required>
                            <option value="enrolled">Matriculado</option>
                            <option value="retired">Retirado</option>
                            <option value="approved">Aprobado</option>
                            <option value="failed">Reprobado</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>


                    <div class="flex items-center justify-end gap-3 mt-6">
                        <x-danger-button x-on:click.prevent="$dispatch('close')">
                            Cancelar
                        </x-danger-button>

                        <x-primary-button>
                            Actualizar Matrícula
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    </x-card>

    {{-- Modal para Crear Nueva Matrícula --}}
    <x-modal name="create-new-enrollment">
        <div class="p-5">
            <h2 class="text-gray-900 text-2xl font-medium mb-6 dark:text-gray-100">Registrar Nueva Matrícula</h2>
            <form method="POST" action="{{ route('enrollments.store') }}">
                @csrf

                <div>
                    <x-input-label for="student_id" value="Alumno" />
                    <select id="student_id" name="student_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
                        required>
                        <option value="">Seleccione un alumno</option>
                        @foreach ($students as $student)
                            @if ($student->deleted_at != null)
                                <option disabled>
                                    {{ $student->name }} {{ $student->lastname }}
                                    ({{ $student->student_code }})
                                    - INACTIVO
                                </option>
                            @else
                                <option value="{{ $student->id }}"
                                    {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} {{ $student->lastname }}
                                    ({{ $student->student_code }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="course_id" value="Curso" />
                    <select id="course_id" name="course_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
                        required>
                        <option value="">Seleccione un curso</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }} ({{ $course->course_code }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="period" value="Periodo Académico" />
                    <x-text-input id="period" class="block mt-1 w-full" type="text" name="period"
                        :value="old('period')" placeholder="2024-II" required>
                        <x-icon-calendar />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('period')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="enrollment_date" value="Fecha de Matrícula" />
                    <x-text-input id="enrollment_date" class="block mt-1 w-full" type="date"
                        name="enrollment_date" :value="old('enrollment_date', now()->format('Y-m-d'))" required>
                        <x-icon-calendar />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('enrollment_date')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="status" value="Estado de la Matrícula" />
                    <select id="status" name="status"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
                        required>
                        <option value="enrolled" {{ old('status', 'enrolled') == 'enrolled' ? 'selected' : '' }}>
                            Matriculado</option>
                        <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }}>Retirado</option>
                        <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Aprobado</option>
                        <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Reprobado</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <x-danger-button x-on:click.prevent="$dispatch('close')">
                        Cancelar
                    </x-danger-button>

                    <x-primary-button>
                        Registrar Matrícula
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
