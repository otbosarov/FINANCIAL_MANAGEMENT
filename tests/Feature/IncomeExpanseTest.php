<?php

namespace Tests\Feature;

use App\Models\IncomeExpanse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class IncomeExpanseTest extends TestCase
{
    public function test_income_expanse_korish(): void
    {
        $token = $this -> post('/api/user/login',[
            'username' => 'jaska',
            'password' => '123'
           ]);
           $token->assertStatus(200);
           $token = $token->json()['token'];

           $income = $this->withHeaders([
           'Authorization' => 'Bearer ' . $token
        ])->get('/api/income_expanses/get');

        $income->assertStatus(200);
    }
    public function test_income_expanse_create_qilish(){
        DB::beginTransaction();
        $token = $this -> post('/api/user/login',[
            'username' => 'jaska',
            'password' => '123'
        ]);
        $token->assertStatus(200);
        $token = $token->json()['token'];

        $income = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('/api/income_expanses/create' , [
            'value' => 10000,
            'currency' => 'UZS',
            'type_id' => '9',
            'comment' => 'rasxod',
            'user_id' => '42'
        ]);

        $income->assertStatus(201);
        DB::rollBack();
    }
    public function test_income_expanse_update_qilish(){
        DB::beginTransaction();
        $token = $this -> post('/api/user/login',[
            'username' => 'jaska',
            'password' => '123'
        ]);
        $token->assertStatus(200);
        $token = $token->json()['token'];

        $expanse = IncomeExpanse::find(39);
        $income = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->put('/api/income_expanses/update/' . $expanse->id , [
            "value" => 5000,
            "type_id" => '8',
            "comment" => 'kirim'
        ]);
        $income->assertStatus(200);
        DB::rollBack();
    }
}
