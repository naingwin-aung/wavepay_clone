<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $id = $this->route('user');

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'. $id,
            'phone' => ['required','unique:users,phone,' . $id,'numeric','regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
            'profile_img' => 'nullable|image',
            'password' => 'nullable|min:6|max:20'
        ];
    }
}
