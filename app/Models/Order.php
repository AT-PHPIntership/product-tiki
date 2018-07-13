<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';

    const APPROVED = 1;
    const UNAPPROVED = 0;
    const CANCELED = 3;
    const ON_DELIVERY = 2;
    
    const ORDER_DESC = 'DESC';
    const ORDER_ASC = 'ASC';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'total', 'status',
    ];

    /**
     * Get User Object
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get OrderDetail for Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id', 'id');
    }

    /**
     * Get Cancel Order of Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function noteOrder()
    {
        return $this->hasMany('App\Models\NoteOrder', 'order_id', 'id');
    }

    /**
     * Get time changed status order
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function trackingOrder()
    {
        return $this->hasMany('App\Models\TrackingOrder', 'order_id', 'id');
    }
}
