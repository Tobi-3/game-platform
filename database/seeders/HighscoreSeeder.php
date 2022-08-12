<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class HighscoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        for ($i=0; $i < 20; $i++) {
            DB::table('highscores')->upsert([
                'username' => 'tobsel',
                'game' => 'game' . strval(random_int(0, 4)),
                'score' => random_int(0, 1000000),
            ],['username, game'], ['score']);
        }

        for ($i=0; $i < 20; $i++) {
            DB::table('highscores')->upsert([
                'username' => 'tobsel' . strval(random_int(0,4)),
                'game' => 'game'. strval(random_int(0,4)),
                'score' => random_int(0, 1000000),
            ], ['username', 'game'], ['score']);
        }
    }
}
