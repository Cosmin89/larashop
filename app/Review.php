<?php

namespace larashop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function likes()
    {
        return $this->morphToMany('larashop\User', 'likeable')->whereDeletedAt(null);
    }

    public function getIsLikedAttribute()
    {
        $like = $this->likes()->whereUserId(Auth::id())->first();
        return (!is_null($like)) ? true : false;
    }
}
