<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'full_name' => 'required|string|min:1|max:50',
            'username' => 'required|string|min:3|max:60|unique:users,username',
            'password' => 'required|string|min:3|max:50',
            'phone' => 'required|starts_with:+998|size:17|string|unique:users,phone'
        ];
    }
    public function messages(){
        return [
            'full_name.required' => 'To\'liq ism kiritish majburiy!',
            'full_name.min:1' => 'To\'liq ismni minimal qiymati 1 ta belgidan ortiq bo\'lishi kerak ',
            'full_name.max:60' => 'To\'liq ismni maxsimal qiymati 50 ta belgidan ortiq bo\'lmasligi kerak',
            'username.required' => 'Login kiritish majburiy!',
            'username.min' => 'Loginni minimal qiymati 3 ta belgidan ortiq bo\'lishi kerak ',
            'username.max' => 'Loginni maxsimal qiymati 60 ta belgidan ortiq bo\'lmasligi kerak',
            'username.unique' => 'Bu login band, qaytadan kiriting',
            'password.required' => 'Parol kiritish majburiy!',
            'password.min' => 'Parolni minimal qiymati 3 ta belgidan ortiq bolishi kerak',
            'password.max' => 'Parolni maxsimal qiymati 50 ta belgidan ortiq bolmasligi kerak',
            'phone.required' => 'Telefon nomer kiriting',
            'phone.starts_with' => 'Telefon raqamning boshi  +998 boshlanishi kerak ',
            'phone.size' => 'Telefon nomer kiritish maydoni 17 ta belgidan iborat bolishii kerak ',
            'phone.unique' => 'Bu raqam allaqachon mavjud'
        ];
    }
}
