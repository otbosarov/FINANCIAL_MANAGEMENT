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
        "qiymati"=>$this->value,
        "valyuta_turi"=>$this->currency,
        "kategoriyasi"=>$this->user_types->title,
        "nomi_izohi"=>$this->comment,
        "foydalanuvchi_ismi"=>$this->user_income->full_name,
        "Xarajat_yaratilgan_vaqt"=>$this->dateTime,
        "Faol_yoki_Nafaolligi"=> $this->active,
        "yaratilgan_sana"=>$this->created_at->format('d.m.Y H:i:s'),
        "ozgartirilgan_sana"=> $this->updated_at->format('d.m.Y H:i:s')
        ];
    }
}
