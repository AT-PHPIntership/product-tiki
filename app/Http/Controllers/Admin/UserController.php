<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = User::with('userinfo')->find($id);
        $data['result'] = $result;
        return view('admin.pages.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     * @param int                      $id      id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $userInfo = UserInfo::where('user_id', $id)->firstOrFail();
            $userInfo->full_name = $request->full_name;
            $userInfo->address = $request->address;
            $userInfo->phone = $request->phone;
            if ($request->gender) {
                $userInfo->gender = $request->gender;
            }
            $userInfo->dob = $request->dob;
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $nameNew = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/avatar/');
                $userInfo->avatar = $nameNew;
                $userInfo->save();
                $image->move($destinationPath, $nameNew);
            } else {
                $userInfo->avatar = $request->avatar;
                $userInfo->save();
            }
            $msg = trans('messages.update_user_success');
            return redirect()->route('admin.users.index')->with('message', $msg);
        } catch (ModelNotFoundException $e) {
            $msg = trans('messages.update_user_fail');
            return redirect()->back()->with('message', $msg);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.users.create');
    }
}
