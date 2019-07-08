<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'description'];

    public function customers () {
        return $this->belongsToMany(Customer::class);
    }
}
