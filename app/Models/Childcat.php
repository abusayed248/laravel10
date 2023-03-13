<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Childcat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cat_id', 'subcat_id','childcat_name','childcat_slug',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function subcat()
    {
        return $this->belongsTo(Subcategory::class, 'subcat_id');
    }
}
