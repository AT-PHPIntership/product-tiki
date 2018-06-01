<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
    * Remove the specified resource from storage.
    *
    * @param int $id comment id
    *
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            $msg = __('post.admin.form.deleted');
        } catch (ModelNotFoundException $e) {
            $msg = __('post.admin.form.id_not_found');
        } finally {
            $data['msg'] = $msg;
            return $data;
        }
    }
}
