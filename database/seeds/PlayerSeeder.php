<?php

use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'name' => 'Player 1',
            'is_full' => false
        ],[
            'name' => 'Player 2',
            'is_full' => false
        ]];
        DB::table('players')->insert($data);
    }
}
