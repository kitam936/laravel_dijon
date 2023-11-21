<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            [
            'id' => 11,
            'ar_name' => '北関東',
            ],
            [
            'id' => 12,
            'ar_name' => '南関東',
            ],
            [
            'id' => 14,
            'ar_name' => '中京',
            ],



        ]);
    }
}
