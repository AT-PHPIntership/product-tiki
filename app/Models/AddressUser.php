<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressUser extends Model
{
    protected $table = 'address_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userinfo_id', 'address',
    ];

    /**
     * Get UserInfo of Address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userinfo()
    {
        return $this->belongsTo('App\Models\UserInfo', 'userinfo_id', 'id');
    }
}
