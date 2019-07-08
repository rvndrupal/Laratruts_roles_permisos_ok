<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $guarded = ['id'];

    public function order () {
        return $this->belongsTo(Order::class);
    }
}
