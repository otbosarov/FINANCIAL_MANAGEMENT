<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeExpanse extends Model
{
    use HasFactory;
    protected $fillable = [
    'value',
    'currency',
    'type_id',
    'comment',
    'user_id',
    'dateTime',
];
     public function user_income(){
        return $this->hasOne(User::class,'id','user_id');
     }
     public function user_types(){
        return $this->hasOne(Type::class,'id','type_id');
     }
}
