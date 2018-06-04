<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\UserInfo;
use Sesstion;

class CreateUserRequest extends FormRequest
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
        return [
            'username'       => 'required|string|max:100|unique:users',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => 'required|string|min:6',
            'fullname'       => 'string|max:255',
            'avatar'         => 'image|mimes:png,jpg,jpeg',
            'birthday'       => 'date_format:"Y-m-d"',
            'gender'         => 'required|integer|min:0|max:1',
            'address'        => 'string|max:255',
            'phone'          => 'regex:/\(?([0-9]{3})\)?([ . -]?)([0-9]{3})\2([0-9]{4})/',
            'identity_card'  => 'regex:/\(?([0-9]{3})\)?([ . -]?)([0-9]{3})\2([0-9]{3})/|unique:user_info',
        ];
    }
}
