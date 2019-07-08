<?php

namespace App;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, FormAccessible;

    protected $guarded = ['id'];

    public function orderLines () {
        return $this->hasMany(OrderLine::class);
    }

    public function customer () {
        return $this->belongsTo(Customer::class);
    }

    public function paymentMethod () {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function formCreatedAtAttribute ($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
