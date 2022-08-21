
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
        <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->username }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('admin.logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        <form method="GET" action="{{ route('delete.profile') }}">
                            @csrf

                            <x-dropdown-link :href="route('delete.profile')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Delete Profile') }}
                            </x-dropdown-link>
                        </form>

                        <form method="GET" action="{{ route('change.password') }}">
                            @csrf

                            <x-dropdown-link :href="route('change.password')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Change Password') }}
                            </x-dropdown-link>
                        </form>
                        
                        <form method="GET" action="{{ route('change.username') }}">
                            @csrf

                            <x-dropdown-link :href="route('change.username')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Change Username') }}
                            </x-dropdown-link>
                        </form>
                        
                       
                    </x-slot>
                </x-dropdown>
            </div>

        
    </x-slot>

        <div class="relative flex-col items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            

            <div class="mt-12 grid border-solid place-items-center max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="font-semibold text-xl text-gray-800 leading-tights">
                    {{Auth::user()->username}}
                </div>
                <div class="sm:rounded-lg bg-white overflow-hidden flex align-middle justify-center pt-8 sm:justify-start sm:pt-0">
                    <img class="" src="{{ asset($picture_path) }}" alt="">
                </div>
                <form method="POST" action="{{ route('change.picture') }}" class="flex" enctype="multipart/form-data">
                    @csrf
                    <div >
                        
                        <x-input id="picture" class="block mt-1 w-full" type="file"  name="picture" :value="old('picture')" accept=".jpg,.jpeg,.png,.svg" autofocus />
                    </div>
                    <x-button class="ml-3">
                     {{ __('Change Picture') }}
                     </x-button>
                     @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
                <div></div>
                <h3 class="mt-9 font-semibold text-xl text-gray-900 leading-tight">
                    {{ __('Game Rankings') }}
                </h3>
            </div>
            <div class="py-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        
                        <div class="flex justify-between p-6 bg-white border-b border-gray-200">
                                <div>{{ __('GAME') }}</div> 
                                <div>{{ __('SCORE')}}</div> 
                                <div>{{__('RANK')}}</div> 
                        </div>
                        @foreach ($game_ranks as $game) 
                        <div class="flex justify-between p-6 bg-white border-b border-gray-200">
                                <div>{{ $game->game }}</div> 
                                <div>{{ $game->score}}</div> 
                                <div>{{ $game->rank }}</div> 
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> 
</x-app-layout>

