<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Response;
use Auth;

class CommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Post         $post    post to get commments
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post, Request $request)
    {
        $perPage = isset($request->perpage) ? $request->perpage : config('define.post.limit_rows');

        $comments = Comment::with(['user.userInfo'])->where('post_id', $post->id)->orderBy('id', 'DESC')->paginate($perPage);
        foreach ($comments as $comment) {
            $comment['image_path'] = config('app.url').config('define.images_path_users');
        }
        $data = $this->formatPaginate($comments);

        return $this->showAll($data, Response::HTTP_OK);
    }

    /**
    * Display a list comments of user logged in.
    *
    * @param \Illuminate\Http\Request $request request
    *
    * @return \Illuminate\Http\Response
    */
    public function getComments(Request $request)
    {
        Auth::user();
        $perPage = isset($request->perpage) ? $request->perpage : config('define.post.limit_rows');

        $comments = Comment::paginate($perPage);

        $data = $this->formatPaginate($comments);

        return $this->showAll($data, Response::HTTP_OK);
    }
}
