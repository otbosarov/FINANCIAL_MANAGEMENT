<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeExpanseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

        "id"=>$this->id,
        "Qiymati"=>$this->value,
        "Valyuta_turi`"=>$this->currency,
        "Xarajat_turi"=>$this->user_types->title,
        "Xarajat_Izohi"=>$this->comment,
        "Xarajat_yaratgan_foydalanuvchi"=>$this->user_income->full_name,
        "Xarajat_yaratilgan_vaqt"=>$this->dateTime,
        "Faol_yoki_Nafaolligi"=> $this->active,
        "Yaratilgan_sanasi"=>$this->created_at->format('d.m.Y H:i:s'),
        "O'zgartirilgan_sana"=> $this->updated_at->format('d.m.Y H:i:s')
        ];
    }
}
