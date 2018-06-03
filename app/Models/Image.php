<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'product_id', 'img_url',
    ];

    /**
     * Get Images of Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    /**
     * Get the Product's image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset(config('define.product.upload_image_url') . $this->img_url);
    }
}
