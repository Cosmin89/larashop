<?php

namespace larashop;

use larashop\Address;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['amount', 'address_id', 'user_id', 'payment_id'];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function products()
    {
        return $this->belongsToMany('larashop\Product')->withPivot('quantity')->withTimestamps();
    }

   
}
