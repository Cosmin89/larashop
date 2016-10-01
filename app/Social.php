<?php

namespace larashop;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'users_social';

    protected $fillable = ['social_id', 'service'];

    public function user()
    {
        return $this->belongsTo('larashop\User');
    }
}
