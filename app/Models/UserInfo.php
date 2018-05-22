<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'full_name', 'avatar', 'gender', 'dob', 'address', 'phone', 'identity_card',
    ];

    /**
     * Get User Info of User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get the user's avatar.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return asset(config('define.images_path_users') . $this->avatar);
    }
}
