<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Http\FormRequest;

class TransferFormRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'to_phone.required' => __('request.to_phone.required'),
            'to_phone.numeric' => __('request.to_phone.numeric'),
            'to_phone.regex' => __('request.to_phone.regex'),
        ];
    }
}
