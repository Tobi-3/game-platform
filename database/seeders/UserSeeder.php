<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'username' => "tobsel",
            'email' => 'tobias.awotula@uni-tuebingen.de',
            'password' => Hash::make('password'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'username' => "tobsel$i",
                'email' => "tobsel$i" . '@randmail.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
