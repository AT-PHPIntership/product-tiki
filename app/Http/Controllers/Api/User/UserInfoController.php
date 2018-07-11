<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use App\Models\UserInfo;
use App\Models\User;
use Validator;
use Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AddressUser;

class UserInfoController extends ApiController
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $updatedUser = $request->only(['full_name', 'address', 'gender', 'phone', 'identity_card', 'avatar', 'dob']);

        $user = Auth::user();

        try {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $newImage = time() . '-' . str_random(8) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path(config('define.images_path_users'));
                $updatedUser['avatar'] = $newImage;
                $image->move($destinationPath, $newImage);
            }
            UserInfo::updateOrCreate(['user_id' => $user->id], $updatedUser);
            $user->load('userinfo');
            return $this->showOne($user, Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse(trans('messages.update_user_fail'), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAddress()
    {
        $user = Auth::user();

        $userInfo = $user->userInfo;
        $addressList = AddressUser::where('userinfo_id', $userInfo->id)->get();
        return $this->showAll($addressList, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request
     * @param \App\Models\AddressUser  $address address to update
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAddress(Request $request, AddressUser $address)
    {
        $user = Auth::user();

        if ($user->userInfo->id == $address->userinfo_id) {
            $address->address = $request->address;
            $address->save();
            return $this->showOne($address, Response::HTTP_OK);
        } else {
            throw new AuthenticationException();
        }
    }
}
