<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeOrderStatus extends Model
{
    protected $table = 'time_order_status';

    const APPROVED = 1;
    const UNAPPROVED = 0;
    const CANCELED = 3;
    const ON_DELIVERY = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'status', 'date_changed',
    ];

    /**
     * Get status order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}
