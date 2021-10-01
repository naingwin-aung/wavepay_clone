<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
        $id = $this->route('admin');

        return [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'. $id,
            'phone' => ['required','unique:admins,phone,' . $id,'numeric','regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
            'password' => 'nullable|min:6|max:20'
        ];
    }
}
