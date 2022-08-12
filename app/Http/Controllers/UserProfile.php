<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Controller
{
    //
    public function userProfile()
    {   
        //get rank of current user for all games played
        $game_ranks =
        DB::select(
            'SELECT * FROM
              (SELECT username, game, score, row_number() 
                OVER (PARTITION BY game ORDER BY score) as rank 
               FROM highscores) as rankings
               WHERE username = ?', [ Auth::user()->username ]
        );
            
        // DB::select(
        //     'SELECT username, game, score, row_number() OVER (PARTITION BY game ORDER BY score) as rank FROM highscores ORDER BY username, game, rank'
        // );

        $picture = Auth::user()->picture;
                    

        return view('user-profile', [
            'picture_path' => $picture,
            'game_ranks'=> $game_ranks ]);
    }
}
