<?php

namespace larashop;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'address', 'city', 'postal_code', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('larashop\User', 'user_id');
    }

    public function fullAddress()
    {
        return "$this->address $this->city $this->postal_code";
    }
}
