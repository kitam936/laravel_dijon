<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HinbanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hinbans')->insert([
            [
            'id' => 138101,
            'brand_id' => 1,
            'unit_id' => 10,
            'year_code' => 3,
            'shohin_gun' => 38,
            'hinmei' => 'TBISシャツ',
            'm_price' => 4600,
            'price' => 4600,
            'cost' => 1400,
            'vendor_id' => 8301,
            'hin_info' => 'TBIS',
            ],
            [
            'id' => 138401,
            'brand_id' => 1,
            'unit_id' => 10,
            'year_code' => 3,
            'shohin_gun' => 38,
            'hinmei' => 'TBISカットソー',
            'm_price' => 3600,
            'price' => 3600,
            'cost' => 1200,
            'vendor_id' => 8301,
            'hin_info' => 'TBIS',
            ],
            [
            'id' => 138701,
            'brand_id' => 1,
            'unit_id' => 10,
            'year_code' => 3,
            'shohin_gun' => 38,
            'hinmei' => 'TBISニット',
            'm_price' => 4900,
            'price' => 4900,
            'cost' => 1600,
            'vendor_id' => 8301,
            'hin_info' => 'TBIS',
            ],




        ]);
    }
}
