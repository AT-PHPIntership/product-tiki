<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listCategories = Category::with('parentCategories')->withCount('products')->paginate(config('define.category.limit_rows'));
        $data['listCategories'] = $listCategories;
        return view('admin.pages.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listCategoriesParent = Category::get();
        $data['listCategoriesParent'] = $listCategoriesParent;
        return view('admin.pages.categories.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request get request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (!$request->parent_id) {
            $request['level'] = 0;
        } else {
            $parentLvl = Category::find($request->parent_id)->level;
            $request['level'] = $parentLvl + 1;
        }
        if (Category::create($request->all())) {
            return redirect()->route('admin.categories.index')->with('message', __('category.admin.message.add'));
        } else {
            return redirect()->route('admin.categories.create')->with('message', __('category.admin.message.add_fail'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id category's id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $selfCat = Category::find($id);
        $parentCat = Category::where('level', '<=', $selfCat->level)->get();
        $data['selfCat'] = $selfCat;
        $data['parentCat'] = $parentCat;
        return view('admin.pages.categories.edit', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id category's id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $itemCategory = Category::with('parentCategories')->find($id);
        $childCategory = Category::with('categories')->where('parent_id', $id)->get();
        $data['itemCategory'] = $itemCategory;
        $data['childCategory'] = $childCategory;
        return view('admin.pages.categories.show', $data);
    }
}
