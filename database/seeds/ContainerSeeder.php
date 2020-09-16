<?php

use Illuminate\Database\Seeder;

class ContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'player_id' => 1,
            'capacity' => 10,
            'total' => 0
        ],[
            'player_id' => 2,
            'capacity' => 10,
            'total' => 0
        ]];
        DB::table('containers')->insert($data);
    }
}
