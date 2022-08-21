<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create multiple game entries
        for ($i = 0; $i < 5; $i++) {
            DB::table('games')->insert([
                'name' => "game$i",
                'path' => Storage::url("games/game$i"),
                'creator' => 'admin'
            ]);
        }
    }
}
