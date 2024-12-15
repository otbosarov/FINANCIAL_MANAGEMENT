<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequset extends FormRequest
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
            'username' => 'required|string|min:3|max:60',
            'password' => 'required|string|min:3|max:50',
        ];
    }
    public function messages(){
        return [
            'username.required' => 'Login kiritish majburiy!',
            'username.min' => 'Loginni minimal qiymati 3 ta belgidan ortiq bo\'lishi kerak ',
            'username.max' => 'Loginni maxsimal qiymati 60 ta belgidan ortiq bo\'lmasligi kerak',
            'password.required' => 'Parol kiritish majburiy!',
            'password.min' => 'Parolni minimal qiymati 3 ta belgidan ortiq bolishi kerak',
            'password.max' => 'Parolni maxsimal qiymati 50 ta belgidan ortiq bolmasligi kerak',
        ];
    }
}
