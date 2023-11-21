<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\Sale;
use App\Models\Delivery;
use App\Models\Area;
use App\Models\Stock;



class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'shop_name',
        'company_id',
        'shop_info',
        'area_id',
        'filename',
        'is_selling',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }

    public function delivery()
    {
        return $this->hasMany(Delivery::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }


}
