<?php

namespace App\Services;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Models\User;
use App\Models\UserInfo;

class SocialAccountService
{

    /**
         * Store User when user never login
         *
         * @param \Illuminate\Http\Request $providerUser providerUser
         * @param \Illuminate\Http\Request $social       social
         *
         * @return data token
         */
    public static function createOrGetUser(ProviderUser $providerUser, $social)
    {
        $account = User::where('social_id', $providerUser->id)->first();
        if ($account) {
            $data['token'] = $account->createToken('token')->accessToken;
            $data['user'] = $account->load('userinfo');
        } else {
            $user = User::create([
                'email' => $providerUser->email,
                'social_id' => $providerUser->id,
                'type' => $social,
            ]);
            $user->userinfo()->create([
                'full_name' => $providerUser->name,
                'avatar' => $providerUser->avatar,
            ]);
            $data['token'] = $user->createToken('token')->accessToken;
            $data['user'] = $user->load('userinfo');
        }
        return $data;
    }
}
