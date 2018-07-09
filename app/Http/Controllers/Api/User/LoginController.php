<?php
namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\ApiController;
use App\Models\UserInfo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;
use App\Http\Requests\CreateUserRequest;
use App\Mail\SendMailUser;
use Mail;

class LoginController extends ApiController
{
    /**
     * Login as user
     *
     * @return json authentication code
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $data['token'] =  $user->createToken('token')->accessToken;
            $data['user'] = $user->load('userInfo');
            return $this->successResponse($data, Response::HTTP_OK);
        } else {
            return $this->errorResponse(config('define.login.unauthorised'), Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Register user
     *
     * @param App\Http\Requests\CreateUserRequest $request validated request
     *
     * @return json authentication code with user info
     */
    public function register(CreateUserRequest $request)
    {
        $input = $request->only(['username', 'email', 'password']);
        $mail = new SendMailUser($input);
        $input['password'] = bcrypt($input['password']);
        $userInfoData = $request->except(['username', 'email', 'password']);

        $user = User::create($input);

        $userInfoData['user_id'] = $user->id;

        UserInfo::create($userInfoData);

        Mail::to($user->email)->send($mail);

        $data['token'] =  $user->createToken('token')->accessToken;
        $data['user'] =  $user->load('userInfo');

        return $this->successResponse($data, Response::HTTP_OK);
    }

    /**
     * Get user details
     *
     * @return json user, userInfo
     */
    public function details()
    {
        $user = Auth::user();
        $data['user'] = $user->load('userInfo');
        return $this->successResponse($data, Response::HTTP_OK);
    }

    /**
     * Logout
     *
     * @return 204
     */
    public function logout()
    {
        $user = Auth::user();
        $accessToken = $user->token();
        \DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        $user->last_logined_at = Carbon::now();
        $user->save();

        return $this->successResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Check access token api
     *
     * @return \Illuminate\Http\Response
     */
    public function checkAccessToken()
    {
        if (Auth::user()) {
            $user = Auth::user();
            return $this->successResponse($user, Response::HTTP_OK);
        }
    }
}
