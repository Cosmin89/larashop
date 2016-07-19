<?php

namespace larashop;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['title', 'content', 'product_id', 'user_id'];

    public function product()
    {
        return $this->belongsTo('larashop\Product', 'product_id');
    }

    public function user()
    {
        return $this->belongsTo('larashop\User', 'user_id');
    }
}
