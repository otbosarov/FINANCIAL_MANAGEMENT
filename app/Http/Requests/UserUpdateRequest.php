<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'password' => 'required|string|min:3',
            'phone' => [
            'required',
            'starts_with:+998',
            'size:17',
            'string',
            Rule::unique('users')->ignore($this->id),
        ],
            // 'phone' => 'required|starts_with:+998|size:17|string',
            // 'phone' => [Rule::unique('users')->where(function($query){
            //     $query->where('phone', $this->phone)->where('id', '!=',$this->id);
            // })]
        ];
    }
    public function messages(){
        return [
           'full_name.required' => 'To\'liq ism kiritish majburiy!',
        'full_name.min' => 'To\'liq ismning minimal uzunligi 1 ta belgidan ortiq bo\'lishi kerak.',
        'full_name.max' => 'To\'liq ismning maksimal uzunligi 50 ta belgidan oshmasligi kerak.',
        'password.required' => 'Parol kiritish majburiy!',
        'password.min' => 'Parolning minimal uzunligi 3 ta belgidan ortiq bo\'lishi kerak.',
        'password.max' => 'Parolning maksimal uzunligi 50 ta belgidan oshmasligi kerak.',
        'phone.required' => 'Telefon raqamini kiritish majburiy!',
        'phone.starts_with' => 'Telefon raqami +998 bilan boshlanishi kerak.',
        'phone.size' => 'Telefon raqami uzunligi 17 ta belgidan iborat bo\'lishi kerak.',
        'phone.unique' => 'Bu raqam allaqachon mavjud.',
        ];
    }
}
