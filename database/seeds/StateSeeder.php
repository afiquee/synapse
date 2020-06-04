<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            ['name' => 'Johor'],
            ['name' => 'Kedah'],
            ['name' => 'Kelantan'],
            ['name' => 'Melaka'],
            ['name' => 'Negeri Sembilan'],
            ['name' => 'Pahang'],
            ['name' => 'Penang'],
            ['name' => 'Perak'],
            ['name' => 'Perlis'],
            ['name' => 'Sabah'],
            ['name' => 'Sarawak'],
            ['name' => 'Selangor'],
            ['name' => 'Terengganu'],
        ]);
    }
}
