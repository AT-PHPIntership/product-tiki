<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FilterTrait;

class Product extends Model
{
    use FilterTrait;
    use SoftDeletes;
    protected $table = 'products';
    const AVAILABLE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'preview', 'description', 'total_rate', 'rate_count', 'avg_rating', 'price', 'quantity', 'quantity_sold', 'status',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get OrderDetail Object
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail', 'product_id', 'id');
    }

    /**
     * Get Image of Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\Image', 'product_id', 'id');
    }

    /**
     * Get Post of Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'product_id', 'id');
    }

    /**
     * Get Category Object
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    /**
     * Get Meta Data Object
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function metaData()
    {
        return $this->hasMany('App\Models\MetaData', 'product_id', 'id');
    }
}
