<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sku;
use App\Models\Brand;
use App\Models\Unit;



class Hinban extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'unit_id',
        'brand_id',
        'year_code',
        'shohin_gun',
        'hinmei',
        'm_price',
        'price',
        'cost',
        'vendor_id',
        'hin_info'

    ];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
