<?php

use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'item_id' => '1',
            'stock' => 100,
            'stock_reserved' => 10,
            'stock_available' => 90,
        ],[
            'item_id' => '2',
            'stock' => 100,
            'stock_reserved' => 10,
            'stock_available' => 90,
        ]];
        DB::table('inventories')->insert($data);
    }
}
