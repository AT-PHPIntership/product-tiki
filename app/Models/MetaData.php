<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaData extends Model
{
    protected $table = 'meta_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_key', 'meta_data', 'product_id'
    ];

    /**
     * Get User of CancelOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function meta()
    {
        return $this->belongsTo('App\Models\MetaData', 'meta_key', 'key');
    }

    /**
     * Get User of CancelOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
