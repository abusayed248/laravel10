<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pickup_name','pickup_phone','pickup_address',
    ];
}
