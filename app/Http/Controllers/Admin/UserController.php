<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Mail\SendMailUser;
use Mail;

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
     * @param App\Models\User $user user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data['user'] = $user;
        return view('admin.pages.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     * @param int                      $user    user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $updatedUser = $request->except(["_token", "_method", "submit", "username", "email"]);
        try {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $newImage = time() . '-' . str_random(8) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path(config('define.images_path_users'));
                $updatedUser['avatar'] = $newImage;
                $image->move($destinationPath, $newImage);
            }
            UserInfo::updateOrCreate(['user_id' => $user->id], $updatedUser);
            return redirect()->route('admin.users.index')->with('message', trans('messages.update_user_success'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('message', trans('messages.update_user_fail'));
        }
        return view('admin.pages.users.edit');
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
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $userData = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ];
        $user = User::create($userData);
        $newImage = '';
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $newImage = time() . '-' . str_random(8) . '.' . $image->getClientOriginalExtension();
        }
        $userInfoData = [
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'identity_card' => $request->identity_card,
            'gender' => $request->gender,
            'avatar' => $newImage,
            'dob' => $request->dob,
        ];
        if (UserInfo::create($userInfoData)) {
            if ($newImage) {
                $destinationPath = public_path(config('define.images_path_users'));
                $image->move($destinationPath, $newImage);
            }
        }
        $data['email'] = $user->email;
        $data['password'] = $request->password;
        Mail::to($user->email)->send(new SendMailUser($data));
        return redirect()->route('admin.users.index')->with('message', trans('messages.create_user_success'));
    }
}
