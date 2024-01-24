<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'shop_id',
        'user_id',
        'image1',
        'image2',
        'image3',
        'image4',
        'comment'

    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
