<x-app-layout>
    <!-- Header -->
    <div class="flex flex-col gap-6 sm:flex-row justify-between items-start">
        <div>
            <h1 class="text-3xl text-gray-800 font-semibold mb-2 dark:text-gray-100">Gestión de Alumnos</h1>
            <p class="text-gray-500 dark:text-gray-400">Administra la información de los estudiantes</p>
        </div>

        <x-primary-button x-data x-on:click="$dispatch('open-modal', 'create-new-student')">
            <x-icon-add />
            Nuevo Alumno
        </x-primary-button>
    </div>

    <x-card x-data="{ selected: null }">
        <x-slot name="header">
            <div class="flex flex-col gap-5 sm:items-center justify-between mb-4 sm:flex-row">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-xl dark:bg-blue-600/10">
                        <x-icon-students />
                    </div>
                    <h3 class="text-xl font-medium text-gray-800 dark:text-gray-100">Lista de Alumnos</h3>
                </div>
                <div class="px-4 py-2 bg-blue-100 rounded-lg dark:bg-blue-600/10">
                    <p class="text-blue-600 font-medium dark:text-blue-500">
                        Total: <span id="studentCount">{{ $students->total() }}</span> estudiantes
                    </p>
                </div>
            </div>
            <x-search-input class="w-full" placeholder="Buscar por nombre, código o email..." />
        </x-slot>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 uppercase tracking-wider text-xs dark:bg-gray-900/10">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium">Nombre
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Código
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Email
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Teléfono
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Semestre
                        </th>
                        <th class="text-left px-6 py-3 font-medium">Fecha de
                            Matriculación</th>
                        <th class="text-left px-6 py-3 font-medium">Estado
                        </th>
                        <th class="text-right px-6 py-3 font-medium">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700">
                    <!-- Rows will be inserted here -->
                    @foreach ($students as $student)
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-gray-900/50">
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200 overflow-hidden text-ellipsis whitespace-nowrap max-w-xs"
                                title="{{ $student->name }}">
                                {{ $student->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200" title="{{ $student->student_code }}">
                                {{ $student->student_code }}
                            </td>
                            <td class="px-6 py-4" title="{{ $student->email }}">
                                {{ $student->email }}
                            </td>
                            <td class="px-6 py-4" title="{{ $student->phone }}">
                                {{ $student->phone }}
                            </td>
                            <td class="px-6 py-4" title="{{ $student->semester }}">
                                {{ $student->semester }}
                            </td>
                            <td class="px-6 py-4" title="{{ $student->created_at->format('d/m/Y') }}">
                                {{ $student->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4" title="{{ $student->deleted_at ? 'inactivo' : 'activo' }}">
                                @if ($student->deleted_at)
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
                                        x-on:click="$dispatch('open-modal', 'edit-student'); selected = @js($student);"
                                        class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-blue-100 hover:text-blue-600 hover:border-blue-400 transition-colors dark:hover:bg-blue-600/10 dark:hover:text-blue-500">
                                        <x-icon-edit />
                                    </button>


                                    @if ($student->deleted_at)
                                        <form action="{{ route('students.restore', $student) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button title="Activar Alumno"
                                                onclick="return confirm('¿Seguro que deseas reactivar al alumno?')"
                                                class="inline-flex items-center p-2 border border-gray-300 rounded-lg hover:bg-green-100 hover:text-green-600 hover:border-green-400 transition-colors dark:hover:bg-green-600/10 dark:hover:text-green-500">
                                                <x-icon-activate />
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('students.destroy', $student) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button title="Desactivar Alumno"
                                                onclick="return confirm('¿Seguro que deseas desactivar al alumno?')"
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
        <div class="py-4 px-6">
            {{ $students->links() }}
        </div>

        <x-modal name="edit-student">
            <div class="p-5">
                <h2 class="text-gray-900 text-2xl font-medium mb-6 dark:text-gray-100">Editar Alumno</h2>
                <form method="POST" action="{{ route('students.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- ID -->
                    <input type="hidden" name="id" x-bind:value="selected?.id">

                    <!-- Código -->
                    <div>
                        <x-input-label for="student_code" value="Código de Alumno" />
                        <x-text-input id="student_code" class="block mt-1 w-full" type="text" name="student_code"
                            :value="old('student_code')" placeholder="001234567" x-bind:value="selected?.student_code" required>
                            <x-icon-code />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('student_code')" class="mt-2" />
                    </div>

                    <!-- Nombres y Apellidos -->
                    <div class="mt-4">
                        <x-input-label for="name" value="Nombres y Apellidos" />

                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            placeholder="Daniel Eduardo Villafranqui Colquicocha" x-bind:value="selected?.name"
                            required>
                            <x-icon-students />
                        </x-text-input>

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" value="Correo Electrónico" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" placeholder="1234567@senati.pe" x-bind:value="selected?.email" required>
                            <x-icon-mail />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Teléfono -->
                    <div class="mt-4">
                        <x-input-label for="phone" value="Teléfono" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                            :value="old('phone')" placeholder="910883895" x-bind:value="selected?.phone" required>
                            <x-icon-phone />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Semestre -->
                    <div class="mt-4">
                        <x-input-label for="semester" value="Semestre" />
                        <x-text-input id="semester" class="block mt-1 w-full" type="number" name="semester"
                            :value="old('semester')" placeholder="5" x-bind:value="selected?.semester" required>
                            <x-icon-calendar />
                        </x-text-input>
                        <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6">
                        <x-danger-button x-on:click.prevent="$dispatch('close')">
                            Cancelar
                        </x-danger-button>

                        <x-primary-button>
                            Actualizar Alumno
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    </x-card>

    <x-modal name="create-new-student">
        <div class="p-5">
            <h2 class="text-gray-900 text-2xl font-medium mb-6 dark:text-gray-100">Añadir Nuevo Alumno</h2>
            <form method="POST" action="{{ route('students.store') }}">
                @csrf

                <!-- Código -->
                <div>
                    <x-input-label for="student_code" value="Código de Alumno" />
                    <x-text-input id="student_code" class="block mt-1 w-full" type="text" name="student_code"
                        :value="old('student_code')" placeholder="001234567" required>
                        <x-icon-code />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('student_code')" class="mt-2" />
                </div>

                <!-- Nombres y Apellidos -->
                <div class="mt-4">
                    <x-input-label for="name" value="Nombres y Apellidos" />

                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        placeholder="Daniel Eduardo Villafranqui Colquicocha" required>
                        <x-icon-students />
                    </x-text-input>

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" value="Correo Electrónico" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" placeholder="1234567@senati.pe" required>
                        <x-icon-mail />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Teléfono -->
                <div class="mt-4">
                    <x-input-label for="phone" value="Teléfono" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                        :value="old('phone')" placeholder="910883895" required>
                        <x-icon-phone />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Semestre -->
                <div class="mt-4">
                    <x-input-label for="semester" value="Semestre" />
                    <x-text-input id="semester" class="block mt-1 w-full" type="number" name="semester"
                        :value="old('semester')" placeholder="5" required>
                        <x-icon-calendar />
                    </x-text-input>
                    <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <x-danger-button x-on:click.prevent="$dispatch('close')">
                        Cancelar
                    </x-danger-button>

                    <x-primary-button>
                        Añadir Alumno
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
