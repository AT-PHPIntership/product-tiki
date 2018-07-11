<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Product;
use App\Models\Post;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\OrderDetail;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request request content
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = isset($request->perpage) ? $request->perpage : config('define.limit_rows');
        $request->order = isset($request->order) ? $request->order : config('define.dir_asc');

        $products = Product::filter($request)->with('category', 'images')
            ->when(isset($request->sortBy), function ($query) use ($request) {
                return $query->orderBy($request->sortBy, $request->order);
            })
            ->when(isset($request->limit), function ($query) use ($request) {
                return $query->limit($request->limit);
            })->paginate($perPage);

        $urlEnd = ends_with(config('app.url'), '/') ? '' : '/';
        foreach ($products as $product) {
            $product['price_formated'] = number_format($product['price']);
            $product['image_path'] = config('app.url') . $urlEnd . config('define.product.upload_image_url');
        }

        $products->appends(request()->query());

        $products = $this->formatPaginate($products);
        return $this->showAll($products, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product show detail product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->category;
        $product->images;
        $product['price_formated'] = number_format($product['price']);
        $urlEnd = ends_with(config('app.url'), '/') ? '' : '/';
        $product['image_path'] = config('app.url') . $urlEnd . config('define.product.upload_image_url');
        return $this->showOne($product, Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Product      $product product to get post
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function getPosts(Product $product, Request $request)
    {
        $perPage = isset($request->perpage) ? $request->perpage : config('define.post.limit_rows');
        $sortBy = isset($request->sortBy) ? $request->sortBy : 'id';
        $order = isset($request->order) ? $request->order : 'asc';
        $type = isset($request->type) ? $request->type : Post::TYPE_REVIEW;

        if ($type == Post::TYPE_REVIEW) {
            $sortBy = isset($request->sortBy) ? $request->sortBy : 'rating';
            $order = isset($request->order) ? $request->order : 'desc';
        }

        $posts = Post::with('user.userInfo')->where('product_id', $product->id)
                ->when(isset($request->rating), function ($query) use ($request) {
                    return $query->where('rating', '>=', $request->rating);
                })
                ->where('type', $type)
                ->where('status', Post::APPROVED)->orderBy($sortBy, $order)->paginate($perPage);
        foreach ($posts as $post) {
            $post['image_path'] = config('app.url').config('define.images_path_users');
            $createdAt = $post->created_at;
            $post['diff_time'] = $createdAt->diffForHumans(now());
        }

        $posts->appends(request()->query());

        $data = $this->formatPaginate($posts);
        return $this->showAll($data, Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function recommend(Request $request)
    {
        $productFilter = $request->product_id ? explode(',', $request->product_id) : [];
        $categoryFilter = $request->category_id ? explode(',', $request->category_id) : [];

        $allProducts = Product::withCount('orderDetails')->with('images')->get();

        $categoryId = $allProducts->whereIn('id', $productFilter)->pluck('category_id')->merge($categoryFilter);
        $parentCat = Category::whereIn('id', $categoryId)->pluck('parent_id');
        $childCat = Category::whereIn('parent_id', $parentCat)->whereNotIn('id', $categoryId);

        $order = OrderDetail::whereIn('product_id', $productFilter)->get();
        $orderArr = OrderDetail::whereIn('order_id', $order->pluck('order_id'))->whereNotIn('product_id', $productFilter)->groupBy('product_id')->get(['product_id']);

        $sameParentCat = $allProducts->whereIn('category_id', $childCat->pluck('id'));
        $inParentCat = $allProducts->whereIn('category_id', $parentCat);
        $sameCat = $allProducts->whereIn('category_id', $categoryId)->whereNotIn('id', $productFilter);
        $sameOrder = $allProducts->whereNotIn('id', $productFilter)->whereIn('id', $orderArr->pluck('product_id'));

        $result = collect();

        foreach ($allProducts as $product) {
            if ($inParentCat->contains($product->id)  || $sameParentCat->contains($product->id)) {
                $product['point'] += 1;
            }
            if ($sameCat->contains($product->id)) {
                $product['point'] += 1;
            }
            if ($sameOrder->contains($product->id)) {
                $product['point'] += 1;
            }
            $product['price_formated'] = number_format($product['price']);
            $urlEnd = ends_with(config('app.url'), '/') ? '' : '/';
            $product['image_path'] = config('app.url') . $urlEnd . config('define.product.upload_image_url');
            $result->push($product->toArray());
        }

        $result = $result->filter(function ($value, $key) {
             return isset($value['point']);
        })->sortByDesc('order_details_count')->sortByDesc('point')->values()->all();

        return $this->successResponse($result, Response::HTTP_OK);
    }
}
