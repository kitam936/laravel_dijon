<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hinban;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'br_name',
        'br_info',
    ];


    public function hinban()
    {
        return $this->hasMany(Hinban::class);
    }
}
