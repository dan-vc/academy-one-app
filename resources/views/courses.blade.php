<x-app-layout>
    <div class="flex flex-col gap-6 sm:flex-row justify-between items-start">
        <div>
            <h1 class="text-3xl text-gray-800 font-semibold mb-2 dark:text-gray-100">Gestión de Cursos</h1>
            <p class="text-gray-500 dark:text-gray-400">Administra la información de los cursos</p>
        </div>

        <x-primary-button x-data x-on:click="$dispatch('open-modal', 'create-new-course')">
            <x-icon-add />
            Nuevo Curso
        </x-primary-button>
    </div>

    <x-card x-data="{ selected: null }">
        <x-slot name="header">
            <div class="flex flex-col gap-5 sm:items-center justify-between mb-4 sm:flex-row">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-orange-100 text-orange-600 rounded-xl dark:bg-orange-600/10">
                        {{-- Icono cambiado a uno más apropiado para "Cursos" --}}
                        <x-icon-courses />
                    </div>
                    <h3 class="text-xl font-medium text-gray-800 dark:text-gray-100">Lista de Cursos</h3>
                </div>
                <div class="px-4 py-2 bg-orange-100 rounded-lg dark:bg-orange-600/10">
                    <p class="text-orange-600 font-medium dark:text-orange-500">
                        Total: <span id="courseCount">{{ $courses->total() }}</span> cursos
                    </p>
                </div>
            </div>
            <form action="#" method="GET">
                @csrf
                <x-text-input type="text" name="search" isSearch value="{{ request('search') }}"
                    placeholder="Buscar por nombre o código..." class="w-full">
                    <x-icon-search />
                </x-text-input>
            </form>
        </x-slot>

        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 dark:bg-gray-900/70 dark:border-gray-700">
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Código
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Nombre
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Docente
                            Asignado
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Créditos
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Capacidad
                            Máx.
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Fecha de
                            Creación</th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Estado
                        </th>
                        <th class="text-right px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-gray-400">
                    @foreach ($courses as $course)
                        <tr
                            class="border-b border-gray-200 hover:bg-gray-50/50 transition-colors dark:border-gray-700 dark:hover:bg-gray-900/50">
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200"
                                title="{{ $course->course_code }}">
                                {{ $course->course_code }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs"
                                title="{{ $course->name }}">
                                {{ $course->name }}
                            </td>
                            <td class="px-6 py-4overflow-hidden text-ellipsis whitespace-nowrap max-w-xs"
                                title="{{ $course->teacher?->name ?? 'Sin asignar' }}">
                                {{-- Maneja el teacher_id nulo --}}
                                {{ $course->teacher?->name ?? 'Sin asignar' }}
                            </td>
                            <td class="px-6 py-4" title="{{ $course->credits }}">
                                {{ $course->credits }}
                            </td>
                            <td class="px-6 py-4" title="{{ $course->max_capacity }}">
                                {{ $course->max_capacity }}
                            </td>
                            <td class="px-6 py-4" title="{{ $course->created_at->format('d/m/Y') }}">
                                {{ $course->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4" title="{{ $course->status }}">
                                {{-- Lógica basada en la columna 'status' (enum) --}}
                                @if ($course->status == 'inactive')
                                    <span
                                        class="px-3 py-2 bg-red-100 rounded-lg text-red-600 dark:bg-red-600/10 dark:text-red-500">
                                        inactivo
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-2 bg-green-100 rounded-lg text-green-600 dark:bg-green-600/10 dark:text-green-500">
                                        activo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-gray-800 dark:text-gray-100">
                                <div class="flex justify-end gap-2">
                                    <button x-data
                                        x-on:click="$dispatch('open-modal', 'edit-course'); selected = @js($course);"
                                        title="Editar Curso"
                                        class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-blue-100 hover:text-blue-600 hover:border-blue-400 transition-colors dark:hover:bg-blue-600/10 dark:hover:text-blue-500">
                                        <x-icon-edit />
                                    </button>

                                    {{-- Lógica de botones basada en 'status' --}}
                                    @if ($course->status == 'inactive')
                                        {{-- Asumiendo una ruta 'courses.activate' para reactivar --}}
                                        <form action="{{ route('courses.restore', $course) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button title="Activar Curso"
                                                onclick="return confirm('¿Seguro que deseas activar el curso?')"
                                                class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-green-100 hover:text-green-600 hover:border-green-400 transition-colors dark:hover:bg-green-600/10 dark:hover:text-green-500">
                                                <x-icon-activate />
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('courses.deactivate', $course) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button title="Desactivar Curso"
                                                onclick="return confirm('¿Seguro que deseas desactivar el curso?')"
                                                class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-red-100 hover:text-red-600 hover:border-red-400 transition-colors dark:hover:bg-red-600/10 dark:hover:text-red-500">
                                                <x-icon-deactivate />
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('courses.destroy', $course) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Eliminar Curso"
                                            onclick="return confirm('¿Seguro que deseas eliminar el curso?')"
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

        {{-- Modal para Editar Curso --}}
        <x-modal name="edit-course">
            <div class="p-5">
                <h2 class="text-gray-900 text-2xl font-medium mb-6 dark:text-gray-100">Editar Curso</h2>
                <form method="POST" action="{{ route('courses.update') }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" x-bind:value="selected?.id">

                    <div>
                        <x-input-label for="course_code" value="Código del Curso" />
                        <x-text-input id="course_code" class="block mt-1 w-full" type="text" name="course_code"
                            placeholder="MAT101" x-bind:value="selected?.course_code" required>
                            <x-icon-code />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('course_code')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="name" value="Nombre del Curso" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            placeholder="Matemática Básica I" x-bind:value="selected?.name" required>
                            <x-icon-courses />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="credits" value="Créditos" />
                        <x-text-input id="credits" class="block mt-1 w-full" type="number" name="credits"
                            placeholder="4" x-bind:value="selected?.credits" required>
                            <x-icon-code />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="max_capacity" value="Capacidad Máxima" />
                        <x-text-input id="max_capacity" class="block mt-1 w-full" type="number" name="max_capacity"
                            placeholder="50" x-bind:value="selected?.max_capacity" required>
                            <x-icon-code />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('max_capacity')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="edit_teacher_id" value="Docente" />
                        <select id="edit_teacher_id" name="teacher_id" x-bind:value="selected?.teacher_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm">
                            <option value="">Sin asignar</option>
                            {{-- Asumiendo que $teachers está disponible en la vista --}}
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="edit_status" value="Estado" />
                        <select id="edit_status" name="status" x-bind:value="selected?.status"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
                            required>
                            <option value="active">Activo</option>
                            <option value="inactive">Inactivo</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>


                    <div class="flex items-center justify-end gap-3 mt-6">
                        <x-danger-button x-on:click.prevent="$dispatch('close')">
                            Cancelar
                        </x-danger-button>

                        <x-primary-button>
                            Actualizar Curso
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    </x-card>

    {{-- Modal para Crear Nuevo Curso --}}
    <x-modal name="create-new-course">
        <div class="p-5">
            <h2 class="text-gray-900 text-2xl font-medium mb-6 dark:text-gray-100">Añadir Nuevo Curso</h2>
            <form method="POST" action="{{ route('courses.store') }}">
                @csrf

                <div>
                    <x-input-label for="course_code" value="Código del Curso" />
                    <x-text-input id="course_code" class="block mt-1 w-full" type="text" name="course_code"
                        :value="old('course_code')" placeholder="MAT101" required>
                        <x-icon-code />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('course_code')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="name" value="Nombre del Curso" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" placeholder="Matemática Básica I" required>
                        <x-icon-courses />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="credits" value="Créditos" />
                    <x-text-input id="credits" class="block mt-1 w-full" type="number" name="credits"
                        :value="old('credits')" placeholder="4" required>
                        <x-icon-code />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="max_capacity" value="Capacidad Máxima" />
                    <x-text-input id="max_capacity" class="block mt-1 w-full" type="number" name="max_capacity"
                        :value="old('max_capacity')" placeholder="50" required>
                        <x-icon-code />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('max_capacity')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="teacher_id" value="Docente" />
                    <select id="teacher_id" name="teacher_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm">
                        <option value="">Sin asignar</option>
                        {{-- Asumiendo que $teachers está disponible en la vista --}}
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="status" value="Estado" />
                    <select id="status" name="status"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
                        required>
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Activo
                        </option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <x-danger-button x-on:click.prevent="$dispatch('close')">
                        Cancelar
                    </x-danger-button>

                    <x-primary-button>
                        Añadir Curso
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
