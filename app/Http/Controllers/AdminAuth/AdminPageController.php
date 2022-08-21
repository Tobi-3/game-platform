<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use ZipArchive;

class AdminPageController extends Controller
{
    /**
     * get all user names and pass them to the dashboard view
    */
    public function adminPageData()
    {   
        $usernames = DB::table('users')->select('username')->get();

        $games = DB::table('games')->select('name')->get();

        return view('admin.dashboard', [
            'usernames' => $usernames,
            'games' => $games
        ]);
    }


    
    /**
     * deletes a user profile and all related data 
     */ 
    public function deleteProfile(Request $request)
    {
        $request->validate([
            'username' => ['required', 'exists:users']
        ]);

        $user = (DB::table('users')
                    ->where('username', $request->username)
                    ->get())[0];

        // delete picture first (if not default avatar)
        if ($user->picture !== '/storage/avatars/default250.svg') {
            Storage::delete(Str::replaceFirst('storage', 'public', $user->picture));
        }

        //delete user data from databases 
        DB::table('users')->where('id', $user->id)->delete();

        return redirect('admin/dashboard')->with('deleted_profile', 'deleted profile successfully');
    }

    /**
     * stores uploaded zip file and extracts the contents
     */
    public function handleGameUpload(Request $request)
    {
        $request->validate([
            'game_zip' => ['required', 'file', 'mimes:zip' ],
            'game_name' => ['required', 'max:30']
        ]);

        $path = $request->file('game_zip')->storeAs('public/games', $request->game_name . '.zip');

        DB::table('games')->upsert([
            'name' => $request->game_name,
            'path' => Storage::url(Str::replaceFirst('public/', '', Str::replaceFirst('.zip', '', $path))),
            'creator' => 'Game Platform'
        ],['name', 'creator'],['path']);

        $zipPath = storage_path("app/public/games/{$request->game_name}");
        
        // delete old extracted folder if game is updated
        Storage::deleteDirectory("/public/games/{$request->game_name}"); 
        
        $zip = new ZipArchive;
        if ($zip->open("{$zipPath}.zip")) {
            $zip->extractTo($zipPath);
            $zip->close();
        } else {
            return redirect('admin/dashboard')->with('error', 'couldn\'t uploaded game');
        }

        return redirect('admin/dashboard')->with('uploaded', 'uploaded game successfully');
    }

    /** 
     * deletes game from storage and database
     */
    public function deleteGame(Request $request)
    {
        $request->validate([
            'game' => ['required', 'exists:games,name']
        ]);

        $game = (DB::table('games')
                  ->where('name', $request->game)
                  ->get())[0];

        // delete game files from storage
        $path = Str::replaceFirst(Storage::url(''), '/public/', $game->path);
        
        Storage::delete($path .'.zip');
        Storage::deleteDirectory($path);
        
        //delete user data from databases 
        DB::table('games')->where('id', $game->id)->delete();

        return redirect('admin/dashboard')->with('deleted_game', 'deleted profile successfully');
    }


    /**
     * changes admin password
     */
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
