<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_value',
        'currency',
        'user_id',
        'credit_value',
    ];
    public function balans(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
