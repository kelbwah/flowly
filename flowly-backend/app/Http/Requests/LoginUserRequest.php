<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class LoginUserRequest extends FormRequest
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
        return [
            'username' => 'required_without:email|min:2|max:16',
            'password' => 'required|min:8',
            'email' => 'required_without:username|email:rfc,strict,dns,spoof,filter,filter_unicode',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HTTPResponseException(response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], 422));
    }
}
