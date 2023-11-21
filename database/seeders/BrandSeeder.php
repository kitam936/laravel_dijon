<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            [
            'id' => 1,
            'br_name' => 'TBIS',
            'br_info' => 'TBIS',
            ],
            [
            'id' => 6,
            'br_name' => 'Mam',
            'br_info' => 'Mam',
            ],
            [
            'id' => 7,
            'br_name' => 'notorico',
            'br_info' => 'notorico',
            ],



        ]);
    }
}
