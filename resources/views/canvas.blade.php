<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        

        <title>{{ config('app.name', 'Laravel') }}</title>


        <!--- ajax -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

     
        

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="flex justify-between max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                   <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                       {{ $game->name }} by: {{ $game->creator }}
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="py-12 flex justify-around">

                    <div class="flex justify-around">
                        <div ><div id="score" name= score class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">{{__('Score')}}</div>
    
                    </div>

                    <iframe id="myFrame" width="600x" height="500px" scrolling="no" frameboreder="0" src="{{ $game->path }}/index.html" ></iframe>
                 
                    <div >
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-between p-6 bg-white ">
                            <table>
                                <tr>
                                    <th> Rank </th>
                                    <th> User </th>
                                    <th> Score </th>
                                </tr>
                                @foreach ($highscores as $i => $highscore)
                                    <tr>
                                        <td>{{$i + 1}}.</td>
                                        <td>{{$highscore->username}}</td>
                                        <td style="color: rgb(0, 102, 255)">{{$highscore->score}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                    </div>
              
            
        
        
               {{-- jquery --}}
               <script>
                    $(document).ready(function(){

                        $('#myFrame').on('load', function() {
                            var iFrameContent = document.getElementById("myFrame").contentWindow.document;
                            var iFrameCanvas = iFrameContent.getElementById('canvas');
                            var iFrameScore =  iFrameContent.getElementById("score");
                        
                            var points = document.getElementById('score');
                            
                            iFrameScore.addEventListener('DOMSubtreeModified', function () {
                                points.innerHTML = iFrameScore.innerHTML;
                            });
                    
                        })
                    }); 
                </script>
            @auth
                @if (Auth::user()->hasVerifiedEmail())
                    <script>
                    $(document).ready(function(){          
                        $('#myFrame').on('load', function () {
                            var iFrameContent = document.getElementById("myFrame").contentWindow.document;
                            var iFrameCanvas = iFrameContent.getElementById('canvas');
                            var iFrameScore =  iFrameContent.getElementById("score");
                            var points = document.getElementById('score');
                        
                            var gameOverDiv = iFrameContent.getElementById('gameOver');          
                            gameOverDiv.addEventListener('DOMSubtreeModified', function () {
                                if (this.innerHTML == 'true') {
                                    //update highscore
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                        
                                    $.ajax({
                                        url: '/update-highscore',
                                        type: "post",
                                        data: {'score': points.innerHTML, 'game': "{{$game->name}}" },
                                        dataType: 'JSON',
                                        success: function (data) {
                                        console.log("brudi:"); // this is good
                                        console.log(data); // this is good
                                        }
                                    });
                                }               
                            });
                        })
                    }); 
                </script>
                @else
                
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="flex justify-center p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            
                            <a class="underline" href="{{route('user.profile')}}">verify your email</a> &nbsp; {{ __('to save your score')}}
                        </div>
                    </div>
                
                @endif
            @else
            @endauth
            </main>
        </div>
    </body>
</html>


