<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\UserInfo;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route()->parameter('user');
        $userInfo = User::with('userInfo')->where('id', $user->id)->get();
        $identity = $userInfo[0]['userInfo']->identity_card;
        return [
            'fullname'       => 'string|max:255',
            'avatar'         => 'image|mimes:png,jpg,jpeg',
            'birthday'       => 'date_format:"Y-m-d"',
            'address'        => 'string|max:255',
            'phone'          => 'regex:/\(?([0-9]{3})\)?([ . -]?)([0-9]{3})\2([0-9]{4})/',
            'identity_card'  => 'regex:/\(?([0-9]{3})\)?([ . -]?)([0-9]{3})\2([0-9]{3})/|unique:user_info,identity_card,' . $identity .',identity_card',
        ];
    }
}
