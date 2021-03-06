<?php

namespace larashop;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'customerID', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatarUrl()
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email) }}?d=mm&s=40";
    }

    public function orders()
    {
        return $this->hasMany('larashop\Order');
    }

    public function reviews()
    {
        return $this->hasMany('larashop\Review');
    }

    public function addresses()
    {
        return $this->hasMany('larashop\Address');
    }

    public function roles()
    {
        return $this->belongsToMany('larashop\Role', 'user_role', 'user_id', 'role_id');
    }

    public function hasAnyRole($roles)
    {
        if(is_array($roles)) {
            foreach($roles as $role) {
                if($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if($this->hasRole($role)) {
                return true;
            }
        }
        
        return false;
    }

    public function hasRole($name)
    {
        foreach($this->roles as $role)
        {
            if($role->name == $name) return true;
        }

        return false;
    }
    
    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    public function likedReviews()
    {
        return $this->morphedByMany('larashop\Review', 'likeable')->whereDeletedAt(null);
    }

    public function social()
    {
        return $this->hasMany('larashop\Social');
    }

    public function hasSocialLinked($service)
    {
        return (bool) $this->social->where('service', $service)->count();
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
