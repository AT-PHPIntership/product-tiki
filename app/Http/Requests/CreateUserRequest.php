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
            'address'        => 'string|max:255',
            'phone'          => '/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/|max:15',
            'identity_card'  => 'string|digits:9|unique:user_info',
        ];
    }
}
