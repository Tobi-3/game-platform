
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Games') }}
        </h2>
    </x-slot>

        <div class="relative flex-col items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            

            <div class="grid border-solid place-items-center max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div>
                    {{Auth::user()->username}}
                </div>
                <div class="flex align-middle justify-center pt-8 sm:justify-start sm:pt-0">
                    <img class="" src="{{ asset($picture_path) }}" alt="">
                </div>
            </div>

            <div class="py-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            Gameranks
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                       
                        @foreach ($game_ranks as $game)  
                        <div class="p-6 bg-white border-b border-gray-200">
                            {{ $game->username }},  SCORE: {{ $game->score}},  {{ $game->game }}: RANK #{{ $game->rank}}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    
</x-app-layout>

