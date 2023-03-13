<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'warehouse_name','warehouse_phone','warehouse_address',
    ];
}
