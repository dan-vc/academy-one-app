<nav x-data="{ open: false }" class="sm:sticky top-0 sm:h-screen flex flex-col sm:w-64 bg-[#141E30] text-white trantision">
    <!-- Primary Navigation Menu -->
    <div class="flex sm:flex-col h-full justify-between w-full p-4 sm:p-0">
        <!-- Logo -->
        <div class="shrink-0 flex items-center justify-center sm:py-6 px-4 sm:border-b border-gray-700">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden p-4 mt-1 sm:flex flex-col gap-4">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <x-icon-dashboard />
                Dashboard
            </x-nav-link>
            <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.index')">
                <x-icon-students />
                Alumnos
            </x-nav-link>
            <x-nav-link :href="route('teachers.index')" :active="request()->routeIs('teachers.index')">
                <x-icon-teachers />
                Docentes
            </x-nav-link>
            <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.index')">
                <x-icon-courses />
                Cursos
            </x-nav-link>
            <x-nav-link :href="route('enrollments.index')" :active="request()->routeIs('enrollments.index')">
                <x-icon-enrollments />
                Matrículas
            </x-nav-link>
            <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')">
                <x-icon-reports />
                Reportes
            </x-nav-link>
            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                <x-icon-user />
                Perfil
            </x-nav-link>
        </div>

        <div class="hidden sm:block px-4 mt-auto">
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-danger-button class="w-full justify-center">
                    Cerrar Sesión
                </x-danger-button>
            </form>
        </div>

        <div class="hidden sm:block mt-4 px-4 py-2 border-t border-gray-700">
            <div class="px-3 py-4 flex gap-3">
                <div class="flex items-center justify-center bg-blue-600 rounded-full aspect-square w-10 h-10">AO</div>
                <div class="block">
                    <div class="font-medium">Academy One</div>
                    <div class="text-gray-500 text-sm">v1.0.0</div>
                </div>
            </div>
        </div>

        <!-- Hamburger -->
        <div class="flex items-center sm:hidden">
            <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-400 hover:bg-gray-900 focus:outline-none focus:bg-gray-900 focus:text-gray-400 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>


    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.index')">
                Alumnos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('teachers.index')" :active="request()->routeIs('teachers.index')">
                Docentes
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.index')">
                Cursos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('enrollments.index')" :active="request()->routeIs('enrollments.index')">
                Matrículas
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')">
                Reportes
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Perfil
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
