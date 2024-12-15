<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
             'title' => 'required|string|min:1|max:60',
             'is_input' => 'required|boolean',
        ];
    }
    public function messages(){
        return[
            'title.required' => 'Xarajat turini kiritish majburiy!',
            'title.min:1' => 'Xarajat turi kamida 1 ta belgidan iborat bo\'lishi kerak',
            'title.max:60' => 'Xarajat turi ko\'pi bilan 60 ta dan oshmasligi kerak',
            'is_input.boolean' => 'Kirim-chiqim qiymati 0 yoki 1 qiymat qabul qiladi '
        ];
    }
}
