<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discount', 'discount_type', 'coupon_code', 'min_total', 'max_total', 'date_begin', 'date_end',
    ];

    /**
     * Get order for coupon
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'coupon_id', 'id');
    }
}
