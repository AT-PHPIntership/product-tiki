<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Sortable;

    const ADMIN_ROLE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role' , 'api_token' , 'old_password' , 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * Get UserInfo of User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userinfo()
    {
        return $this->hasOne('App\Models\UserInfo', 'user_id', 'id');
    }

    /**
     * Get Comment of User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'user_id', 'id');
    }

    /**
     * Get Post of User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'user_id', 'id');
    }

    /**
     * Get Order of User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'user_id', 'id');
    }

    public $sortable = ['id'];
    
    /**
     * Check if user is Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function isAdmin()
    {
        return $this->role == $this::ADMIN_ROLE;
    }
}
