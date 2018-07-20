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
     * Login facebook
     *
     * @param \Illuminate\Http\Request $request facebook access token
     *
     * @return json authentication code
     */
    public function facebook(Request $request)
    {
        $facebook = $request->only('access-token');

        $fbConnect = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v3.0',
        ]);

        try {
            $response = $fbConnect->get('/me?fields=id,name,picture,email', $facebook['access-token']);
            $profile = $response->getGraphUser();

            if (!$profile || !isset($profile['id'])) {
                return $this->errorResponse(config('define.login.unauthorised'), Response::HTTP_UNAUTHORIZED);
            }
            $avatar = $profile['picture']['url'] ?? null;
            $email = $profile['email'] ?? null;

            $social = User::where('social_id', $profile['id'])->where('social_type', config('define.social.type.facebook'))->first();

            if ($social) {
                $user = $social;
            } else {
                $user = $email ? User::firstOrCreate(['email' => $email]) : User::create();
                $user->update([
                    'social_id' => $profile['id'],
                    'social_type' => config('define.social.type.facebook'),
                ]);

                $user->userinfo()->create([
                    'full_name' => $profile['name'],
                    'avatar' => $avatar,
                ]);

                $user->save();
            }
            Auth::login($user);
            $data['token'] = $user->createToken('token')->accessToken;
            $data['user'] = $user->load('userInfo');

            return $this->successResponse($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage, Response::HTTP_BAD_REQUEST);
        }
    }

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
