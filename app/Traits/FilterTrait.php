<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Category;

trait FilterTrait
{
    /**
     * Filter with request data
     *
     * @param \Illuminate\Database\Eloquent\Builder|static $query   query
     * @param \Illuminate\Http\Request                     $request request
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function scopeFilter($query, Request $request)
    {
        return static::where(function ($query) use ($request) {
            if ($request->category) {
                $categories = Category::all()->toArray();
                $categoriesId = static::getCategoryId($categories, $request->category);
                $query->whereIn('category_id', $categoriesId);
            }
            if ($request->name) {
                $query->where('name', 'like', '%'.$request->name.'%');
            }
            if ($request->price) {
                $values = explode(",", $request->price);
                $query->whereBetween('price', $values);
            }
            if ($request->rating) {
                $query->where('avg_rating', '>=', $request->rating);
            }
        });
    }

    /**
     * Get Array id of category
     *
     * @param array  $categoriesArray   all categories array
     * @param string $categoriesRequest categories's id request array
     *
     * @return array
     */
    public static function getCategoryId(array $categoriesArray, $categoriesRequest)
    {
        $categoryId = array();
        foreach (explode(',', $categoriesRequest) as $categoryRequest) {
            array_push($categoryId, $categoryRequest);
            foreach ($categoriesArray as $category) {
                if ($category['parent_id'] == $categoryRequest) {
                    array_push($categoryId, $category['id']);
                }
            }
        }
        return $categoryId;
    }
}
