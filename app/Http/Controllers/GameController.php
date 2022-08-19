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

        // var_dump([$highscores, $game]);
        return view('canvas', [
            'game' => $game[0],
            'highscores' => $highscores
        ]);
    }
     
    public function updateHighscore(Request $request)
    {   
        
        $userHighscore = DB::table('highscores')
                           ->where('username', Auth::user()->username)
                           ->where('game', $request->game)
                           ->get();


        $oldScore = $userHighscore->isEmpty() ? -1 : $userHighscore[0]->score;
        $newScore = $request->score;
        if ( $oldScore  < $newScore) {
            DB::table('highscores')->upsert([
                'username' => Auth::user()->username,
                'game' => $request->game,
                'score' => $newScore,
            ],['username, game'], ['score']);
            }

        
    }
}

    // [0] => object(Illuminate\Support\Collection) (2) { 
    //     ["items":protected]=> array(1) { 
    //         [0]=> object(stdClass) (5) 
    //             { ["username"] => string(6) "tobsel" 
    //               ["game"]=> string(6) "Tetris" 
    //               ["score"]=> int(136) 
    //               ["created_at"]=> NULL 
    //               ["updated_at"]=> NULL } } 
    //     ["escapeWhenCastingToString":protected]=> bool(false) } 


    // [1] => object(Illuminate\Support\Collection) (2) { 
    //     ["items":protected]=> array(1) { 
    //         [0]=> object(stdClass) (6) { 
    //             ["id"]=> int(36) 
    //             ["name"]=> string(6) "Tetris" 
    //             ["path"]=> string(21) "/storage/games/Tetris" 
    //             ["creator"]=> string(13) "Game Platform" 
    //             ["created_at"]=> NULL 
    //             ["updated_at"]=> NULL } } 
    //     ["escapeWhenCastingToString":protected]=> bool(false) } 



    