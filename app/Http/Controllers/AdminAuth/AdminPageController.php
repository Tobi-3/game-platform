<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Dotenv\Store\StoreInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use ZipArchive;

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


    
    // deletes a user profile and all related data 
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

        DB::table('games')->insert([
            'name' => $request->game_name,
            'path' => Storage::url(Str::replaceFirst('public/', '', Str::replaceFirst('.zip', '', $path))),
            'creator' => 'Game Platform'
        ]);

        $zipPath = storage_path("app/public/games/{$request->game_name}");

        $zip = new ZipArchive;
        if ($zip->open("{$zipPath}.zip")) {
            $zip->extractTo($zipPath);
            $zip->close();
        } else {
            return redirect('admin/dashboard')->with('errror', 'couldn\'t uploaded game');
        }

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

        // delete gamefiles from storage
        $path = Str::replaceFirst(Storage::url(''), '/public/', $game->path);
        Storage::delete($path);
        Storage::deleteDirectory(Str::replaceFirst('.zip', '', $path));
        
       
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
