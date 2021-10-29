<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopUpPhoneRequest extends FormRequest
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
            'bill_phone' => ['required','numeric','regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
        ];
    }

    public function messages()
    {
        return [
            'bill_phone.required' => __('request.bill_phone.required'), 
            'bill_phone.numeric' => __('request.phone.numeric'), 
            'bill_phone.regex' => __('request.phone.regex'), 
        ];
    }
}
