<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cat_id','subcat_name','subcat_slug',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
}
