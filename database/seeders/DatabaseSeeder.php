<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Shop;
use App\Models\Brand;
use App\Models\Hinban;
use App\Models\Sku;
use App\Models\Col;
use App\Models\Sz;
use App\Models\Unit;
use App\Models\Sale;
use App\Models\Delivery;
use App\Models\Area;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            AreaSeeder::class,
            ShopSeeder::class,
            BrandSeeder::class,
            UnitSeeder::class,
            HinbanSeeder::class,
            SaleSeeder::class,
            DeliverySeeder::class,

        ]);
    }
}
