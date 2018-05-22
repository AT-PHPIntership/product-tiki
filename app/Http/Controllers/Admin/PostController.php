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
     * @param \Illuminate\Http\Request $request request content
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = config('define.post.limit_rows');
        $posts = Post::when(isset($request->content), function ($query) use ($request) {
            return $query->where('content', 'like', "%$request->content%");
        })->when(isset($request->post_status), function ($query) use ($request) {
            return $query->where('status', '=', $request->post_status);
        })
        ->with(['user','product'])->paginate($perPage);
        $posts->appends(request()->query());
        $data['posts'] = $posts;
        return view('admin.pages.posts.index', $data);
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
        $post = Post::findOrFail($id);
        if ($post) {
            $post->delete();
            session(['message' => __('post.admin.form.deleted')]);
            return redirect()->route('admin.posts.index');
        } else {
            session(['message' => __('post.admin.form.id_not_found')]);
        }
    }
}
