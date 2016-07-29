<?php

namespace larashop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use SoftDeletes;

    protected $table = 'likeables';

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type'
    ];

    public function reviews()
    {
        return $this->morphedByMany('larashop\Review', 'likeable');
    }
}
