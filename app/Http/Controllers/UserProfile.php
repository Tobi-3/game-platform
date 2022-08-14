<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;


class UserProfile extends Controller
{
    //
    public function getDataForProfile()
    {   
        //get rank of current user for all games played
        $game_ranks = DB::select(
                        'SELECT * FROM
                            (SELECT username, game, score, rank() 
                                OVER (PARTITION BY game ORDER BY score) as rank 
                            FROM highscores) as rankings
                        WHERE username = ?', [ Auth::user()->username ]
        );


        $picture = Auth::user()->picture;
                    

        return view('user-profile', [
            'picture_path' => $picture,
            'game_ranks'=> $game_ranks ]);
    }

    // upload and set new profile picture 
    public function changePicture(Request $request)
    {   //TODO: set maximum size for image
        $request->validate([
            // 'picture' => 'required'
            'picture' => 'required|image|mimes:jpg,jpeg,png,svg'
        ]);


        // $path = $request->file('picture')->store('public/avatars');
        $path = $request->file('picture')->storeAs('public/avatars', Auth::user()->id);

        DB::table('users')
            ->where('username', Auth::user()->username)
            ->update(['picture' => Storage::url(Str::replaceFirst('public/', '', $path))]);

        
        return redirect('user-profile')->with('status', 'Picture changed successfully');
    }


    // deletes user profile and all  related data
    public function deleteProfile()
    {   
        $user = Auth::user();

        // delete picture first (if not default avatar)
       if (!$user->picture === '/storage/avatars/default250.svg') {
            Storage::delete(Str::replaceFirst('storage', 'public', $user->picture));
       }

        //delete user data from databases 
        DB::table('users')->where('id', $user->id)->delete();

        return redirect('login')->with('message', 'deleted profile successfully');
    }

    // changes password of usser
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::table('users')
          ->where('id', $request->user()->id)
          ->update(['password' => Hash::make($request->password) ]);

        return redirect('user-profile')->with('message', 'changed password succesfully');
    }

    //changes username
    public function changeUserName(Request $request)
    {   
        $request->validate([
            'new_username' => ['required', 'confirmed', 'max:30']
        ]);

        // $user = Auth::user();
        DB::table('users')->where('id', $request->user()->id)
          ->update(['username' => $request->new_username]);
        
        return redirect('user-profile')->with('message', 'changed username succesfully');
    }


}
