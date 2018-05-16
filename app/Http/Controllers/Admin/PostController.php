<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = new Post();
        $perPage = $post->perPage;
        $posts = Post::with(['user', 'product'])->paginate($perPage);
        foreach ($posts as $post) {
            $post->user;
            $post->product;
        }
        $data['type'] = 'index';
        $data['posts'] = $posts;
        return view('admin.pages.posts.index', $data);
    }

    /**
     * Display a listing of the resource with condition
     *
     * @param \Illuminate\Http\Request $request request content
     *
     * @return \Illuminate\Http\Response
     */
    public function findByContent(Request $request)
    {
        $post = new Post();
        $perPage = $post->perPage;
        $posts = Post::where('content', 'like', '%'.$request->content.'%')->with(['user', 'product'])->paginate($perPage);
        foreach ($posts as $post) {
            $post->user;
            $post->product;
        }
        $data['type'] = 'search';
        $data['posts'] = $posts;
        return view('admin.pages.posts.index', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id post id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showComments()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showReviews()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id post id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     * @param int                      $id      post id
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
     * @param int $id post id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
    }
}
