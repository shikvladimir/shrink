<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected $stopOnFirstFailure = false;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:50'],
            'email' => ['required','email','unique:users'],
            'pass' => ['required', 'min:4','string','max:50'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строкой.',
            'name.max' => 'Поле "Имя" не может содержать более 50 символов.',

            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Поле "Email" должно быть действительным email-адресом.',
            'email.unique' => 'Этот email уже зарегистрирован.',

            'pass.required' => 'Поле "Пароль" обязательно для заполнения.',
            'pass.string' => 'Поле "Пароль" должно быть строкой.',
            'pass.min' => 'Пароль должен содержать не менее 4 символов.',
            'pass.max' => 'Пароль не может превышать 50 символов.',
        ];
    }
}
