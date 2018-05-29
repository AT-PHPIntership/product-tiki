<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Image;

class ImageController extends Controller
{
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
            $img = Image::findOrFail($id);
            $img->delete();

            return response()->json($img);
        } catch (ModelNotFoundException $e) {
            return response()->setStatusCode(400);
        }
    }
}
