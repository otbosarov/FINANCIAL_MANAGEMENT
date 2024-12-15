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
            'phone' => 'required|starts_with:+998|size:17|string',
            'phone' => [Rule::unique('users')->where(function($query){
                $query->where('phone', $this->phone)->where('id', '!=',$this->id);
            })]
        ];
    }
    public function messages(){
        return [
            'full_name.required' => 'To\'liq ism kiritish majburiy!',
            'full_name.min:1' => 'To\'liq ismni minimal qiymati 1 ta belgidan ortiq bo\'lishi kerak ',
            'full_name.max:60' => 'To\'liq ismni maxsimal qiymati 50 ta belgidan ortiq bo\'lmasligi kerak',
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
