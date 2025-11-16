<x-app-layout>
    <!-- Header -->
    <div class="flex justify-between items-start">
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
            <div class="flex items-center justify-between mb-4">
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
            <form action="#" method="GET">
                @csrf
                <x-text-input type="text" name="search" isSearch value="{{ request('search') }}"
                    placeholder="Buscar por nombre, apellido o email..." class="w-full">
                    <x-icon-search />
                </x-text-input>
            </form>
        </x-slot>

        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 dark:bg-gray-900/70 dark:border-gray-700">
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Nombre
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Código
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">DNI o C.E.
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Título
                            Profesional
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Cursos
                            Activos
                        </th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Fecha de
                            Ingreso</th>
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Estado
                        </th>
                        <th class="text-right px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-500">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-gray-400">
                    <!-- Rows will be inserted here -->
                    @foreach ($teachers as $teacher)
                        <tr
                            class="border-b border-gray-200 hover:bg-gray-50/50 transition-colors dark:border-gray-700 dark:hover:bg-gray-900/50">
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200"
                                title="{{ $teacher->name }}">
                                {{ $teacher->name }}
                            </td>
                            <td class="px-6 py-4" title="{{ $teacher->name }}">
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

                                            <button title="Activar Docente" onclick="return confirm('¿Seguro que deseas reactivar al alumno?')"
                                                class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-green-100 hover:text-green-600 hover:border-green-400 transition-colors dark:hover:bg-green-600/10 dark:hover:text-green-500">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15.58 12C15.58 13.98 13.98 15.58 12 15.58C10.02 15.58 8.42004 13.98 8.42004 12C8.42004 10.02 10.02 8.42004 12 8.42004C13.98 8.42004 15.58 10.02 15.58 12Z"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M12 20.27C15.53 20.27 18.82 18.19 21.11 14.59C22.01 13.18 22.01 10.81 21.11 9.39997C18.82 5.79997 15.53 3.71997 12 3.71997C8.46997 3.71997 5.17997 5.79997 2.88997 9.39997C1.98997 10.81 1.98997 13.18 2.88997 14.59C5.17997 18.19 8.46997 20.27 12 20.27Z"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button title="Desactivar Docente"
                                                onclick="return confirm('¿Seguro que deseas desactivar al docente?')"
                                                class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-red-100 hover:text-red-600 hover:border-red-400 transition-colors dark:hover:bg-red-600/10 dark:hover:text-red-500">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M14.53 9.47004L9.47004 14.53C8.82004 13.88 8.42004 12.99 8.42004 12C8.42004 10.02 10.02 8.42004 12 8.42004C12.99 8.42004 13.88 8.82004 14.53 9.47004Z"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M17.82 5.76998C16.07 4.44998 14.07 3.72998 12 3.72998C8.46997 3.72998 5.17997 5.80998 2.88997 9.40998C1.98997 10.82 1.98997 13.19 2.88997 14.6C3.67997 15.84 4.59997 16.91 5.59997 17.77"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M8.42004 19.5301C9.56004 20.0101 10.77 20.2701 12 20.2701C15.53 20.2701 18.82 18.1901 21.11 14.5901C22.01 13.1801 22.01 10.8101 21.11 9.40005C20.78 8.88005 20.42 8.39005 20.05 7.93005"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M15.5099 12.7C15.2499 14.11 14.0999 15.26 12.6899 15.52"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M9.47 14.53L2 22" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M22 2L14.53 9.47" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
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
