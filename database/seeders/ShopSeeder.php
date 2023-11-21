<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            [
            'id' => 1101,
            'company_id' => 1100,
            'shop_name' => '小手指',
            'shop_info' => '',
            'area_id' => 11,
            'filename' => '',
            ],
            [
            'id' => 1201,
            'company_id' => 1200,
            'shop_name' => '久喜',
            'shop_info' => '',
            'area_id' => 12,
            'filename' => '',
            ],
            [
            'id' => 1301,
            'company_id' => 1300,
            'shop_name' => '吉川',
            'shop_info' => '',
            'area_id' => 11,
            'filename' => '',
            ],
            [
            'id' => 1401,
            'company_id' => 1400,
            'shop_name' => '名古屋北',
            'shop_info' => '',
            'area_id' => 14,
            'filename' => '',
            ],
            [
            'id' => 1104,
            'company_id' => 1100,
            'shop_name' => '荻窪',
            'shop_info' => '',
            'area_id' => 11,
            'filename' => '',
            ],



        ]);
    }
}
