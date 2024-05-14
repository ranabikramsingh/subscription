<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseFormRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $exception = $validator->getException();
        $exceptionObject = (new $exception($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
        /*if (request()->expectsJson()) {
            $exceptionObject->response = response()->json([
                'message'   => $exceptionObject->validator->errors()->all()[0],
                'status'    => false,
                'data'      => $exceptionObject->errors()
            ]);
        }
        throw $exceptionObject;*/
        if ($exceptionObject->fails()) {
            // If validation fails, return back with errors
            return redirect()->back()->withErrors($exceptionObject)->withInput();
        }
    }
}
