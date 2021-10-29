<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopUpRequest extends FormRequest
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
            'another_topup_amount' => 'nullable|integer|min:1000',
            'bill_phone' => ['required','numeric','regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
        ];
    }

    public function messages()
    {
        return [
            'another_topup_amount.integer' => __('request.another_topup_amount.integer'),
            'another_topup_amount.min' => __('request.another_topup_amount.min'),
            'bill_phone.required' => __('request.bill_phone.required'), 
            'bill_phone.numeric' => __('request.phone.numeric'), 
            'bill_phone.regex' => __('request.phone.regex'), 
        ];
    }
}
