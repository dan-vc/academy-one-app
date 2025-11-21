<x-app-layout>
    <!-- Header -->
    <div class="flex flex-col gap-6 sm:flex-row justify-between items-start">
        <div>
            <h1 class="text-3xl text-gray-800 font-semibold mb-2 dark:text-gray-100">Gestión de Docentes</h1>
            <p class="text-gray-500 dark:text-gray-400">Administra la información de los profesores</p>
        </div>

        <x-primary-button x-data x-on:click="$dispatch('open-modal', 'create-new-teacher')">
            <x-icon-add />
            Nuevo Docente
        </x-primary-button>
    </div>

    <x-card x-data="{ selected: null }">
        <x-slot name="header">
            <div class="flex flex-col gap-5 sm:items-center justify-between mb-4 sm:flex-row">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-green-100 text-green-600 rounded-xl dark:bg-green-600/10">
                        <x-icon-teachers />
                    </div>
                    <h3 class="text-xl font-medium text-gray-800 dark:text-gray-100">Lista de Docentes</h3>
                </div>
                <div class="px-4 py-2 bg-green-100 rounded-lg dark:bg-green-600/10">
                    <p class="text-green-600 font-medium dark:text-green-500">
                        Total: <span id="teacherCount">{{ $teachers->total() }}</span> docentes
                    </p>
                </div>
            </div>
            <x-search-input class="w-full" placeholder="Buscar por nombre, código o dni..." />
        </x-slot>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 uppercase tracking-wider text-xs dark:bg-gray-900/10">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium">Nombre
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Código
                        </th>
                        <th class="text-left px-6 py-3 font-medium">DNI o C.E.
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Título
                            Profesional
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Cursos
                            Activos
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Fecha de
                            Ingreso</th>
                        <th class="text-left px-6 py-3 font-medium">Estado
                        </th>
                        <th class="text-right px-6 py-3 font-medium">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700">
                    <!-- Rows will be inserted here -->
                    @foreach ($teachers as $teacher)
                        <tr class=" hover:bg-gray-50/50 transition-colors dark:hover:bg-gray-900/50">
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs"
                                title="{{ $teacher->name }}">
                                {{ $teacher->name }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200" title="{{ $teacher->name }}">
                                {{ $teacher->teacher_code }}
                            </td>
                            <td class="px-6 py-4" title="{{ $teacher->dni }}">
                                {{ $teacher->dni }}
                            </td>
                            <td class="px-6 py-4" title="{{ $teacher->profession }}">
                                {{ $teacher->profession }}
                            </td>
                            <td class="px-6 py-4" title="{{ $teacher->courses->count() }}">
                                {{ $teacher->courses->count() }}
                            </td>
                            <td class="px-6 py-4" title="{{ $teacher->created_at->format('d/m/Y') }}">
                                {{ $teacher->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4" title="{{ $teacher->deleted_at ? 'inactivo' : 'activo' }}">
                                @if ($teacher->deleted_at)
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
                                        x-on:click="$dispatch('open-modal', 'edit-teacher'); selected = @js($teacher);"
                                        title="Editar Docente"
                                        class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-blue-100 hover:text-blue-600 hover:border-blue-400 transition-colors dark:hover:bg-blue-600/10 dark:hover:text-blue-500">
                                        <x-icon-edit />
                                    </button>


                                    @if ($teacher->deleted_at)
                                        <form action="{{ route('teachers.restore', $teacher) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button title="Activar Docente"
                                                onclick="return confirm('¿Seguro que deseas reactivar al docente?')"
                                                class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-green-100 hover:text-green-600 hover:border-green-400 transition-colors dark:hover:bg-green-600/10 dark:hover:text-green-500">
                                                <x-icon-activate />
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button title="Desactivar Docente"
                                                onclick="return confirm('¿Seguro que deseas desactivar al docente?')"
                                                class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-red-100 hover:text-red-600 hover:border-red-400 transition-colors dark:hover:bg-red-600/10 dark:hover:text-red-500">
                                                <x-icon-deactivate />
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $teachers->links() }}
        </div>

        <x-modal name="edit-teacher">
            <div class="p-5">
                <h2 class="text-gray-900 text-2xl font-medium mb-6 dark:text-gray-100">Editar Docente</h2>
                <form method="POST" action="{{ route('teachers.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- ID -->
                    <input type="hidden" name="id" x-bind:value="selected?.id">

                    <!-- Código -->
                    <div>
                        <x-input-label for="teacher_code" value="Código del Docente" />
                        <x-text-input id="teacher_code" class="block mt-1 w-full" type="text" name="teacher_code"
                            :value="old('teacher_code')" placeholder="001505049" x-bind:value="selected?.teacher_code" required>
                            <x-icon-code />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('teacher_code')" class="mt-2" />
                    </div>

                    <!-- Nombres y Apellidos -->
                    <div class="mt-4">
                        <x-input-label for="name" value="Nombres y Apellidos" />

                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            placeholder="Giancarlos Barboza Nieto" x-bind:value="selected?.name" required>
                            <x-icon-students />
                        </x-text-input>

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- DNI -->
                    <div class="mt-4">
                        <x-input-label for="dni" value="DNI o C.E." />
                        <x-text-input id="dni" class="block mt-1 w-full" type="text" name="dni"
                            :value="old('dni')" placeholder="75436578" x-bind:value="selected?.dni" required>
                            <x-icon-reports />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                    </div>

                    <!-- Titulo -->
                    <div class="mt-4">
                        <x-input-label for="profession" value="Título Profesional" />
                        <x-text-input id="profession" class="block mt-1 w-full" type="text" name="profession"
                            :value="old('profession')" placeholder="Ingeníero de Sistemas" x-bind:value="selected?.profession"
                            required>
                            <x-icon-teachers />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('profession')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6">
                        <x-danger-button x-on:click.prevent="$dispatch('close')">
                            Cancelar
                        </x-danger-button>

                        <x-primary-button>
                            Actualizar Docente
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    </x-card>

    <x-modal name="create-new-teacher">
        <div class="p-5">
            <h2 class="text-gray-900 text-2xl font-medium mb-6 dark:text-gray-100">Añadir Nuevo Docente</h2>
            <form method="POST" action="{{ route('teachers.store') }}">
                @csrf

                <!-- Código -->
                <div>
                    <x-input-label for="teacher_code" value="Código del Docente" />
                    <x-text-input id="teacher_code" class="block mt-1 w-full" type="text" name="teacher_code"
                        :value="old('teacher_code')" placeholder="001505049" required>
                        <x-icon-code />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('teacher_code')" class="mt-2" />
                </div>

                <!-- Nombres y Apellidos -->
                <div class="mt-4">
                    <x-input-label for="name" value="Nombres y Apellidos" />

                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        placeholder="Giancarlos Barboza Nieto" required>
                        <x-icon-students />
                    </x-text-input>

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- DNI -->
                <div class="mt-4">
                    <x-input-label for="dni" value="DNI o C.E." />
                    <x-text-input id="dni" class="block mt-1 w-full" type="text" name="dni"
                        :value="old('dni')" placeholder="75436578" required>
                        <x-icon-reports />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                </div>

                <!-- Titulo -->
                <div class="mt-4">
                    <x-input-label for="profession" value="Título Profesional" />
                    <x-text-input id="profession" class="block mt-1 w-full" type="text" name="profession"
                        :value="old('profession')" placeholder="Ingeníero de Sistemas" required>
                        <x-icon-teachers />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('profession')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <x-danger-button x-on:click.prevent="$dispatch('close')">
                        Cancelar
                    </x-danger-button>

                    <x-primary-button>
                        Añadir Docente
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
