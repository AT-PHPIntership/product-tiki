<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $table = 'posts';
    
    const TYPE_REVIEW = 1;
    const TYPE_COMMENT = 2;
    const APPROVED = 1;
    const UNAPPROVED = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'user_id', 'type', 'content', 'rating', 'status',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get Product of Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
    /**
     * Get User of Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    /**
     * Get Comment of Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'post_id', 'id');
    }
}
