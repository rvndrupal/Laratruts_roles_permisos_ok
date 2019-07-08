<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'stock', 'image', 'category_id'];

    public function tags () {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function category () {
        return $this->belongsTo(Category::class);
    }
}
