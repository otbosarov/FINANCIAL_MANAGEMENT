<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpansesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'qiymati' => $this->value,
            'valyuta_turi' => $this->currency,
            'katagoriyasi' => $this->title,
            'turi' => $this->is_input,
            'izohi' => $this->comment,
            'foydalanuvchi' => $this->full_name,
            'yaratilgan_sana' => $this->created_at->format('Y-m-d'),
            'ozgartirilgan_sana' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
