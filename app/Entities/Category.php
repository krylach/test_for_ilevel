<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id', 'name'];

    public function products()
    {
        return $this->belongsToMany('App\Entities\Product', 'products_has_categories', 'category_id', 'product_id');
    }
}
