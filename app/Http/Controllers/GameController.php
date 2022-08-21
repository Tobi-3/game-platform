<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class GameController extends Controller
{
    /**
     * gets all game names and passes them to the game overview view
     */
    public function gameNames()
    {

        $games = DB::table('games')->orderBy('name')->get();
       
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
     

    /**
     * updates the score of a game if the new score is higher
     */
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
 