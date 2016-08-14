<?php

namespace larashop;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];
    
    public function users()
    {
        return $this->belongsToMany('larashop\User', 'user_role', 'user_id', 'role_id');
    }
}
