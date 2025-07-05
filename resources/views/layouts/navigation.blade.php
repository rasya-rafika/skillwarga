<nav x-data="{ open: false }" class="bg-gradient-to-r from-pink-100 to-purple-100 border-b border-purple-200 shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-purple-700" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-purple-700 hover:text-purple-900">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link href="{{ url('/cari_jasa') }}" :active="request()->is('cari_jasa')" class="text-purple-700 hover:text-purple-900">
                        {{ __('Cari Jasa') }}
                    </x-nav-link>

                    <x-nav-link href="{{ url('/Daftar_jasa') }}" :active="request()->is('Daftar_jasa')" class="text-purple-700 hover:text-purple-900">
                        {{ __('Daftar Jasa') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown OR Login/Register -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Jika Sudah Login -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-purple-700 bg-white hover:text-purple-900 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    <!-- Jika Belum Login -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 text-sm font-medium text-purple-700 bg-white border border-purple-300 rounded-md hover:bg-purple-100 hover:text-purple-900 transition">
                           Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700 transition">
                           Register
                        </a>
                    </div>
                @endguest
            </div>

            <!-- Hamburger (mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-purple-500 hover:text-purple-700 hover:bg-purple-100 focus:outline-none focus:bg-purple-100 focus:text-purple-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-purple-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-purple-700">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings / Auth -->
        <div class="pt-4 pb-1 border-t border-purple-200">
            @auth
                <!-- Saat Login -->
                <div class="px-4">
                    <div class="font-medium text-base text-purple-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-purple-600">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-purple-700">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-purple-700">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth

            @guest
                <!-- Saat Belum Login -->
                <div class="px-4 space-y-2">
                    <a href="{{ route('login') }}"
                       class="block w-full text-center px-4 py-2 text-sm font-medium text-purple-700 bg-white border border-purple-300 rounded-md hover:bg-purple-100 hover:text-purple-900 transition">
                       Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700 transition">
                       Register
                    </a>
                </div>
            @endguest
        </div>
    </div>
</nav>
