
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
        <div class="flex">
            <form method="GET" action="{{ route('delete.profile') }}">
            @csrf

            <x-button>
                {{ __('Delete Profile') }}
            </x-button>
        </form>

        <form method="GET" action="{{ route('change.password') }}">
            @csrf

            <x-button>
                {{ __('Change Password') }}
            </x-button>
        </form>
        
        <form method="GET" action="{{ route('change.username') }}">
            @csrf

            <x-button>
                {{ __('Change Username') }}
            </x-button>
        </form>
        </div>
    </x-slot>

        <div class="relative flex-col items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            

            <div class="grid border-solid place-items-center max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div>
                    {{Auth::user()->username}}
                </div>
                <div class="flex align-middle justify-center pt-8 sm:justify-start sm:pt-0">
                    <img class="" src="{{ asset($picture_path) }}" alt="">
                </div>
                <form method="POST" action="{{ route('change.picture') }}" class="flex" enctype="multipart/form-data">
                    @csrf
                    <div>
                        {{-- <x-label for="picture" :value="__('Change Picture')" /> --}}

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
            </div>

            <div class="py-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            Ranking
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                       
                        @foreach ($game_ranks as $game)  
                        <div class="p-6 bg-white border-b border-gray-200">
                             {{ $game->game }} Score: {{ $game->score}},   Rank #{{ $game->rank}}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        

    
</x-app-layout>

