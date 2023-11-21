<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\Hinban;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'deliv_date',
        'shop_id',
        'hinban_id',
        'pcs',
        'tanka',
        'kingaku',
        'YM',
        'YW',

    ];



    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function hinban()
    {
        return $this->belongsTo(Hinban::class);
    }


}
