<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = User::with('userinfo')->paginate(config('define.product.limit_rows'));
        $data['result'] = $result;
        return view('admin.pages.users.index', $data);
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
        $result = User::with('userinfo')->find($id);
        $data['result'] = $result;
        return view('admin.pages.users.show', $data);
    }
}
