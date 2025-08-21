<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="block h-9 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:space-x-8 sm:ml-10  space-x-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Tableau de bord</x-nav-link>
                    <x-nav-link :href="route('talk_animation.index')" :active="request()->routeIs('talk_animation.*')">Causerie</x-nav-link>
                    <x-nav-link :href="route('plan.index')" :active="request()->routeIs('plan.*')">Plan</x-nav-link>
                    <x-nav-link :href="route('audit.index')" :active="request()->routeIs('audit.*')">Audit</x-nav-link>
                    <x-nav-link :href="route('event.index')" :active="request()->routeIs('event.*')">Evénement</x-nav-link>
                    <x-nav-link :href="route('action.index')" :active="request()->routeIs('action.*')">Actions</x-nav-link>

                    <!-- Dropdown 1 -->
                    <div x-data="{ open: false }" class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="#" @click.prevent="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 hover:border-gray-300">
                            Mise au Travail Journalière
                            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <div x-show="open" @click.outside="open = false" class="absolute mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <x-nav-link :href="route('daily_readiness.index')" :active="request()->routeIs('daily_readiness.*')" class="block px-4 py-2">Mise au Travail Journalière</x-nav-link>
                            <x-nav-link :href="route('checklist.index')" :active="request()->routeIs('checklist.*')" class="block px-4 py-2">Formulaire de Vérification</x-nav-link>
                        </div>
                    </div>

                    <!-- Dropdown 2 -->
                    <div x-data="{ open: false }" class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="#" @click.prevent="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 hover:border-gray-300">
                            Paramètres
                            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <div x-show="open" @click.outside="open = false" class="absolute mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            @can('Liste des utilisateurs')
                                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="block px-4 py-2">Utilisateurs</x-nav-link>
                            @endcan
                            @can('Liste des roles')
                                <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" class="block px-4 py-2">Rôles</x-nav-link>
                            @endcan
                        </div>
                    </div>

                    <!-- Notification -->
                    <x-nav-link :href="route('fetch.notification')">
                        <i class="fa fa-bell text-lg"></i>
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profil') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                                {{ __('Se déconnecter') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-600 dark:text-gray-400 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
 <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('talk_animation.index')" :active="request()->routeIs('talk_animation.*')">Causerie</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('plan.index')" :active="request()->routeIs('plan.*')">Plan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('audit.index')" :active="request()->routeIs('audit.*')">Audit</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('event.index')" :active="request()->routeIs('event.*')">Evénement</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('action.index')" :active="request()->routeIs('action.*')">Actions</x-responsive-nav-link>

            <!-- Mobile Dropdowns -->
            <details class="px-4 py-2">
                <summary class="cursor-pointer">Mise au Travail Journalière</summary>
                <div class="pl-4">
                    <x-responsive-nav-link :href="route('daily_readiness.index')" :active="request()->routeIs('daily_readiness.*')">Mise au Travail Journalière</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('checklist.index')" :active="request()->routeIs('checklist.*')">Formulaire de Vérification</x-responsive-nav-link>
                </div>
            </details>
            <details class="px-4 py-2">
                <summary class="cursor-pointer">Paramètres</summary>
                <div class="pl-4">
                    @can('Liste des utilisateurs')
                        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">Utilisateurs</x-responsive-nav-link>
                    @endcan
                    @can('Liste des roles')
                        <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">Rôles</x-responsive-nav-link>
                    @endcan
                </div>
            </details>
        </div>

        <!-- Mobile User Menu -->
        <div class="border-t border-gray-200 dark:border-gray-600 pt-4 pb-1">
            <div class="px-4">
                <div class="text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>