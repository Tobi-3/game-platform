<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class=" p-6 bg-white border-b border-gray-200">
                    <form enctype="multipart/form-data" class="flex justify-between" action="{{ route('admin.upload.game')}}" method="post">
                        @csrf
                        
                        <x-input placeholder="game name" type="text" name="game_name" id="game_name"/>
                        <input  type="file" name="game_zip" id="game_zip"/>
                                        
                        <x-button >
                            {{ __('Upload Game') }}
                        </x-button>
                    </form>
                </div>             
                
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" p-6 bg-white border-b border-gray-200">
                    <form class="flex justify-between" action="{{ route('admin.delete.profile')}}" method="post">
                        @csrf
                        
                         <div>
                            <x-input id="username" placeholder="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />
                        </div>
                     
                        <x-button >
                            {{ __('Delete User') }}
                        </x-button>
                    </form>
                </div>

                <div class=" p-6 bg-white border-b border-gray-200">
                    <ul>
                        <h5>Users</h5>    
                        @foreach ($usernames as $user)
                            <li> {{ $user->username }}</li>    
                        @endforeach
                    </ul>    
                </div>
                
                <div class=" p-6 bg-white border-b border-gray-200">
                    <form class="flex justify-between" action="{{ route('admin.delete.game')}}" method="post">
                        @csrf
                        
                         <div>
                            <x-input id="game" placeholder="game name" class="block mt-1 w-full" type="text" name="game" :value="old('game')" required autofocus />
                        </div>
                     
                        <x-button >
                            {{ __('Delete Game') }}
                        </x-button>
                    </form>
                </div>

                <div class=" p-6 bg-white border-b border-gray-200">
                    <ul>
                        <h5>Games</h5>    
                        @foreach ($games as $game)
                        <li> {{ $game->name }}</li>    
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
