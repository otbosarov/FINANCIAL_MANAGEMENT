<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeExpanceRequest extends FormRequest
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
            'value'=>'required|max:12',
            'type_id'=>'required',
             'comment'=>'required|string|max:120',
        ];
    }
    public function messages(){
        return [
            'value.required' => 'Qiymat kiritish majburiy',
            'type_id.required' => 'Xarajat turini kiriting',
            'comment.required' => 'Izoh kiriting',
            'comment.max:120' => 'Izoh ko\'pi bilan 120 ta belgidan oshmasligi kerak',
        ];
    }
}
