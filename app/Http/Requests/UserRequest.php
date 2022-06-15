<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
    public function rules(): array
    {
        if (Request::route()->getName() == 'user.store') {
            $username = 'unique:users,username';
            $email = 'unique:users,email';
            $password = 'required';
        } elseif (Request::route()->getName() == 'user.update') {
            $username = Rule::unique('users', 'username')->ignore(
                $this->route('user')
            );
            $email = Rule::unique('users', 'email')->ignore(
                $this->route('user')
            );
            $password = 'nullable';
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', $username],
            'email' => ['required', 'email', 'max:255', $email],
            'password' => [$password, 'string', 'min:8', 'confirmed'],
        ];

        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            Response::json([
                'status' => 'error',
                'data' => collect($errors)->flatten()->toArray(),
            ], 422)
        );
    }
}