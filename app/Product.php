<?php

namespace larashop;

use larashop\Order;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'price', 'image', 'stock'];
    
    public $quantity = null;

    public function hasLowStock()
    {
        if($this->outOfStock()) {
            return false;
        }

        return (bool) ($this->stock <= 5);
    }

    public function outOfStock()
    {
        return $this->stock === 0;
    }

    public function inStock()
    {
        return $this->stock >= 1;
    }

    public function hasStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    public function orders()
    {
        return $this->belongsToMany('larashop\Order')->withPivot('quantity')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany('larashop\Review');
    }
}
