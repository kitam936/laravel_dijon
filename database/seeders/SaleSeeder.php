<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales')->insert([
            [
            'sales_date' => '2023/10/2',
            'shop_id' => 1101,
            'hinban_id' => 138101,
            'pcs' => 3,
            'tanka' => 4000,
            'kingaku' => 12000,
            'YM' => 202310,
            'YW' => 202332,
            ],
            [
            'sales_date' => '2023/10/3',
            'shop_id' => 1201,
            'hinban_id' => 138401,
            'pcs' => 5,
            'tanka' => 4000,
            'kingaku' => 20000,
            'YM' => 202310,
            'YW' => 202332,
            ],
            [
            'sales_date' => '2023/10/4',
            'shop_id' => 1301,
            'hinban_id' => 138701,
            'pcs' => 10,
            'tanka' => 4000,
            'kingaku' => 40000,
            'YM' => 202310,
            'YW' => 202332,
            ],
            [
            'sales_date' => '2023/10/5',
            'shop_id' => 1401,
            'hinban_id' => 138101,
            'pcs' => 7,
            'tanka' => 4000,
            'kingaku' => 28000,
            'YM' => 202310,
            'YW' => 202332,
            ],


        ]);
    }
}
