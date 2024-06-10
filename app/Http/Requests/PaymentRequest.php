<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PaymentRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'cardnumber' => $request->has('payment_method') ? 'nullable' : 'required',
            'card_holder_name' => 'required',
            'payment_method' => $request->has('payment_method') ? 'required' : 'nullable'
        ];
    }


    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'card.required' => 'Please enter the card details',
            'card_holder_name.required' => 'Please enter the card holder name',
            'payment_method.required' => 'Please enter the card details'
        ];
    }
}
