<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeExpanseUpdateRequest extends FormRequest
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
            "value" => 'required',
            "type_id" => 'required',
            "comment" => 'required'
        ];
    }
    public function messages(){
        return [
            'value.required' => 'Qiymatni kiriting',
            'comment.required' => 'Izoh kiriting ',
            'type_id.required' => 'Xarajat turini kiriting',
        ];
    }
}
