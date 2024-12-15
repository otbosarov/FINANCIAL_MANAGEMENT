<?php

namespace Tests\Feature;

use App\Models\Type;
use Illuminate\Console\View\Components\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TypeTest extends TestCase
{

    public function test_type_show_qilish(): void
    {
        $token = $this->post('/api/user/login', [
            'username' => 'jaska',
            'password' => '123'
        ]);
        $token->assertStatus(200);
        $token = $token->json()['token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get('/api/type/show');

        $response->assertStatus(200);
    }
    public function test_type_create_qilish()
    {
        DB::beginTransaction();
        $token = $this->post('/api/user/login', [
            'username' => 'jaska',
            'password' => '123',
        ]);
        $token->assertStatus(200);
        $token = $token->json()['token'];

        $type = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post('/api/create/type', [
            'title' => "wdcvEDCAW",
            'user_id' => '42',
            'is_input' => "1",
        ]);
        $type->assertStatus(201);
        DB::rollBack();
    }
    public function test_type_update_qilish()
    {
        DB::beginTransaction();
        $token = $this->post('/api/user/login', [
            'username' => 'jaska',
            'password' => '123',
        ]);
        $token->assertStatus(200);
        $token = $token->json()['token'];

        $types = Type::first();
        $type = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->put('/api/type/update/' . $types->id, [
            'title' => "adxq",
            'is_input' => "0",
        ]);
        $type->assertStatus(200);
        DB::rollBack();
    }
    public function test_type_get_all_korish()
    {
            $token = $this->post('/api/user/login', [
            'username' => 'jaska',
            'password' => '123'
        ]);
        $token->assertStatus(200);
        $token = $token->json()['token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get('/api/get_all/type');

        $response->assertStatus(200);
    }
    public function test_change_active_qilish(){
        $token = $this -> post('/api/user/login',[
         'username' => 'jaska',
         'password' => '123'
        ]);
        $token->assertStatus(200);
        $token = $token->json()['token'];
         $actives = Type::first();
        $change = $this->withHeaders([
            'Authorization' => 'Bearer' . $token
        ])->put('/api/change_active/type' . $actives->id);
    }
}
