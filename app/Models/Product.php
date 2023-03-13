<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_id', 'subcat_id','childcat_id','admin_id','warehouse_id','pickup_id','brand_id','p_name','p_slug','p_code','unit','tags','colors','size','stock_qty','purchage_price','regular_price','discount_price','description','video','p_view','thumbnail','images','status','slider','trendy','featured','today_deal','date_time'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function subcat()
    {
        return $this->belongsTo(Subcategory::class, 'subcat_id');
    }

    public function childcat()
    {
        return $this->belongsTo(Childcat::class, 'childcat_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function pickup()
    {
        return $this->belongsTo(Pickup::class, 'pickup_id');
    }


    protected $casts = [
        'slider' => 'boolean',
        'trendy' => 'boolean',
        'featured' => 'boolean',
        'today_deal' => 'boolean',
        'status' => 'boolean',
    ];
}
