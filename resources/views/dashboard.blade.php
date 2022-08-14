<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Games') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @foreach ($games as $game)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between p-6 bg-white border-b border-gray-200">
                    {{ $game->name }}

                    <form method="GET" action="{{ route('canvas', ['game' => $game->name]) }}" >
                    @csrf
                    <x-button>
                        Play
                    </x-butt>
                </form>
                </div>
            </div>


        </div>
        @endforeach
    </div>
</x-app-layout>
