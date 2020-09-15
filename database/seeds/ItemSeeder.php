<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'name' => 'Jilbab',
            'price' => 150000,
        ],[
            'name' => 'Sarung',
            'price' => 100000,
        ]];
        DB::table('items')->insert($data);
    }
}
