<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $game->name }} by: {{ $game->creator }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-around">
        <div>
            <div>{{__('Score:')}}</div>
            <div id="score" name= score></div>
        </div>

        <div>
            
            <canvas name="canvas" id="canvas" width="600px" height="400px" class="border-solid border-black border-4"></canvas>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
                <div class="flex justify-between p-6 bg-white ">
                <table>
                    <tr>
                        <th> Rank </th>
                        <th> User </th>
                        <th> Score </th>
                    </tr>
                    @foreach ($highscores as $i => $highscore)
                        <tr>
                            <td>{{$i + 1}}</td>
                            <td>{{$highscore->username}}</td>
                            <td>{{$highscore->score}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        
    </div>


    
</x-app-layout>
