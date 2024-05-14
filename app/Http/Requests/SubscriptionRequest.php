<?php

namespace App\Http\Requests;

use function App\Helpers\decryptID;
use Illuminate\Validation\Rule;

class SubscriptionRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->method() === 'GET') {
            return [];
        }
        return [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'interval' => 'required|string|max:25',
            'description' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.string' => 'Name required string only',
            'price.numeric' => 'Price must be a number'
        ];
    }

    static public function frontendRules(): array
    {
        return [
            'name'  =>   [
                'required'  => true,
                'minlength' => 3,
                'maxlength' => 50,
                'pattern'   => config('validation.full_name_regex'),
            ],
            'price'    =>   [
                'required' => true,
                'number'    => true,
                'decimalMaxTwo' => true,
                'maxlength' => 8,

            ],
            'interval' => [
                'required' => true,
                'digits'    => true,
                'maxlength' => 12,
            ],
            'description'  => [
                'requiredSummernote' => true,
            ]
        ];
    }

    static public function frontendMessages(): array
    {
        return array(
            'name' => array(
                'required' => 'Name is required',
                'pattern' => 'Name must contain at least one letter and cannot start or end with whitespace.',
                'maxlength' => 'Name not grater than 50 characters',

            ),
            'price' => array(
                'required' => 'Price is required',
                'number' => 'Please enter only numeric values',
                'maxlength' => 'Digit not grater than 8',
                'decimalMaxTwo' => 'Max two digits accept after decimal',
            ),
            'interval' => array(
                'required' => 'Interval is required',
                'maxlength' => 'Digit not grater than 12',
                'digits' => 'Please enter only digits',
            ),
            'description' => array(
                'requiredSummernote' => 'Description is required',
            ),
        );
    }
}
