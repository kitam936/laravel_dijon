<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deliveries')->insert([
            [
            'deliv_date' => '2023/9/2',
            'shop_id' => 1101,
            'sku_id' => 138101990,
            'pcs' => 3,
            'tanka' => 4000,
            'kingaku' => 12000,
            'YM' => 202309,
            'YW' => 202328,
            ],
            [
            'deliv_date' => '2023/9/3',
            'shop_id' => 1201,
            'sku_id' => 138401990,
            'pcs' => 5,
            'tanka' => 4000,
            'kingaku' => 20000,
            'YM' => 202309,
            'YW' => 202328,
            ],
            [
            'deliv_date' => '2023/9/4',
            'shop_id' => 1301,
            'sku_id' => 138701990,
            'pcs' => 10,
            'tanka' => 4000,
            'kingaku' => 40000,
            'YM' => 202309,
            'YW' => 202328,
            ],
            [
            'deliv_date' => '2023/9/5',
            'shop_id' => 1401,
            'sku_id' => 138101990,
            'pcs' => 7,
            'tanka' => 4000,
            'kingaku' => 28000,
            'YM' => 202309,
            'YW' => 202328,
            ],
        ]);
    }
}
