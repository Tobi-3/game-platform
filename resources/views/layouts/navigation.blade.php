<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('/storage/logos') }}/logo_small.png" class="block h-10 w-auto fill-current text-gray-600" alt="go to dashboard">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if (Auth::check())
                    <x-nav-link :href="route('user.profile')" :active="request()->routeIs('user.profile')">
                        {{ __('Profile') }}
                    </x-nav-link>
                    @endif
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Games') }}
                    </x-nav-link>
                </div>
            </div>



            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">



                <!-- Authentication -->
                <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">  
                    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                        @auth
                        
                        

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-button>
                                {{ __('Log Out') }}
                            </x-button>
                            {{-- <x-button onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-button> --}}
                        </form>
                        @else                        
                        @endauth
                    </div>
                </div>



            </div>

            <!-- Hamburger -->
            @auth
                <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @else
                <div class=" top-0 right-0 px-6 py-4 sm:block">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                </div>
                
            @endauth
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Main Page') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('user.profile')" :active="request()->routeIs('user-profile')">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('delete.profile')" :active="request()->routeIs('delete.profile')">
                {{ __('Delete Profile') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('change.password')" :active="request()->routeIs('change.password')">
                {{ __('Change Password') }}
            </x-responsive-nav-link>


        </div>

       
        

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::check()? Auth::user()->username : ''; }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::check()? Auth::user()->email : ''; }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>