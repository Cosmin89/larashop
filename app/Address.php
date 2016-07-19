<?php

namespace larashop;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'address', 'city', 'postal_code',
    ];
}
