<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferAmountFormRequest extends FormRequest
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
            'to_phone' => ['required','numeric','regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
            'amount' => ['required','integer','min:50', 'max:100000000'],
        ];
    }

    public function messages()
    {
        return [
            'to_phone.required' => __('request.to_phone.required'),
            'to_phone.numeric' => __('request.to_phone.numeric'),
            'to_phone.regex' => __('request.to_phone.regex'),
            'amount.required' => __('request.amount.required'),
            'amount.integer' => __('request.amount.integer'),
            'amount.min' => __('request.amount.min'),
            'amount.max' => __('request.amount.max'),
        ];
    }
}
