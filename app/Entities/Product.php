<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['id', 'name'];

    public function categories()
    {
        return $this->belongsToMany('App\Entities\Category', 'products_has_categories', 'product_id', 'category_id');
    }
}
