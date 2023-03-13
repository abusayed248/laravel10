<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'brand_name','brand_slug','brand_logo','status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

}
