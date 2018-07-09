<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
    ];

    /**
     * Get User of CancelOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function metaData()
    {
        return $this->hasMany('App\Models\MetaData', 'meta_key', 'key');
    }
}
