<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\PostProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(config('define.product.limit_rows'));
        $data['products'] = $products;
        return view('admin.pages.products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $data['categories'] = $categories;
        return view('admin.pages.products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PostProductRequest $request)
    {
        $request['status'] = $request->quantity ? 1 : 0;
        $product = Product::create($request->all());

        $img = request()->file('input_img');
        $imgName = time() . '-' . $img->getClientOriginalName();
        $img->move(config('define.product.upload_image_url'), $imgName);
        Image::create([
            'product_id' => $product->id,
            'img_url' => config('define.product.upload_image_url') . $imgName
        ]);

        return redirect()->route('admin.products.index')->with('message', trans('messages.create_product_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        $data['product'] = $product;
        $data['categories'] = $categories;
        return view('admin.pages.products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     * @param int                      $id      id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
        dd($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
        } catch (ModelNotFoundException $e) {
            session()->flash('message', trans('messages.delete_fail'));
        }
        return back();
    }
}
