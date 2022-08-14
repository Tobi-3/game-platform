<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class GameController extends Controller
{
    // get all game names
    public function gameNames()
    {

        $games = DB::table('games')->get();
       
        return view('dashboard', ['games' => $games]);
    }


    public function playGame($game_name)
    {
        $game = DB::table('games')->where('name', $game_name)->get();

        $highscores = DB::table('highscores')
        ->where('game', $game_name)
        ->orderBy('score', 'desc')
        ->limit(10)
            ->get();

        return view('canvas', [
            'game' => $game[0],
            'highscores' => $highscores
        ]);
    }
}
