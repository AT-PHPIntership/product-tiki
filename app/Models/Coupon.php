<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    const PERCENT = 0;
    const MONEY = 1;

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
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function order()
    {
        return $this->hasMany('App\Models\Order', 'coupon_id', 'id');
    }

    /**
     * Validate Coupon
     *
     * @return boolean
     */
    public function isAvailable()
    {
        return Carbon::now()->between(Carbon::parse($this->date_begin), Carbon::parse($this->date_end));
    }
}
