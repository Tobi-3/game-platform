<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AdminPageController extends Controller
{
    // get all user names
    public function adminPageData()
    {   
        $usernames = DB::table('users')->select('username')->get();

        $games = DB::table('games')->select('name')->get();

        return view('admin.dashboard', [
            'usernames' => $usernames,
            'games' => $games
        ]);
    }



    public function deleteProfile(Request $request)
    {
        $request->validate([
            'username' => ['required', 'exists:users']
        ]);

        $user = (DB::table('users')
                    ->where('username', $request->username)
                    ->get())[0];

        // delete picture first (if not default avatar)
        if (! $user->picture === '/storage/avatars/default250.svg') {
            Storage::delete(Str::replaceFirst('storage', 'public', $user->picture));
        }

        //delete user data from databases 
        DB::table('users')->where('id', $user[0]->id)->delete();

        return redirect('admin/dashboard')->with('deleted_profile', 'deleted profile successfully');
    }


    public function handleGameUpload(Request $request)
    {
        $request->validate([
            'game_zip' => ['required', 'file', 'mimes:zip' ],
            'game_name' => ['required', 'max:30']
        ]);

        $path = $request->file('game_zip')->storeAs('public/game_zips', $request->game_name . '.zip');

        DB::table('games')->insert([
            'name' => $request->game_name,
            'path' => Storage::url(Str::replaceFirst('public/', '', $path)),
            'creator' => Auth::guard('admin')->user()->name
        ]);

        return redirect('admin/dashboard')->with('uploaded', 'uploaded game successfully');
    }


    public function deleteGame(Request $request)
    {
        $request->validate([
            'game' => ['required', 'exists:games,name']
        ]);

        $game = (DB::table('games')
                  ->where('name', $request->game)
                  ->get())[0];

        // delete game first (if not default avatar)
        Storage::delete(Str::replaceFirst(Storage::url(''), '/public', $game->path));
        // Storage::delete(Str::replaceFirst('storage', 'public', $game->path));
        

        //delete user data from databases 
        DB::table('games')->where('id', $game->id)->delete();

        return redirect('admin/dashboard')->with('deleted_game', 'deleted profile successfully');
    }


    // changes password of admin
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::table('admins')
            ->where('id', $request->user()->id)
            ->update(['password' => Hash::make($request->password)]);

        return redirect('admin/change-password')->with('changed_password', 'changed password succesfully');
    }


}
