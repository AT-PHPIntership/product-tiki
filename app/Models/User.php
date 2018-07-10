<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, Sortable, HasApiTokens;

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

    /**
     * Get Cancel Order of User
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function noteOrder()
    {
        return $this->hasMany('App\Models\NoteOrder', 'user_id', 'id');
    }

    /**
     * Get social networks of User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialNetwork()
    {
        return $this->hasMany('App\Models\SocialNetwork', 'user_id', 'id');
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
