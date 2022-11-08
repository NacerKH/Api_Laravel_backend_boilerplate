<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsersRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

    return match ($this->method()) {
       'POST'=> ["name" => "required|string|min:5",
                 "email" => "required|email|unique:users,email",
                "password" => "required|min:8|string|confirmed",
                "role"=> "required",
                'profile_photo_path' => 'nullable|mimes:jpg,png,jpeg',
                ],
        'PUT'=>[
                "name" => "required|string|min:5",
                "email" =>  [Rule::unique('users')->ignore($this->user)],
                'profile_photo_path' => 'nullable|mimes:jpg,png,jpeg'
                 ]
                                        };
     }
}
