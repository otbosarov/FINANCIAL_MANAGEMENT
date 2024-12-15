<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_register_qilish()
    {
        DB::beginTransaction();
        $user = $this->post('/api/user/register', [
            'full_name' => Str::random(6),
            'username' => Str::random(4),
            'password' => Str::random(3),
            'phone' => $this->generateRandomPhoneNumber(),
        ]);
        $user->assertStatus(201);
        DB::rollBack();
    }
    public function test_user_login_qilish()
    {
        $token = $this->post('/api/user/login', [
            'username' => 'jaska',
            'password' => '123'
        ]);
        $token->assertStatus(200);
    }

    public function test_user_info_korish(): void
    {
        $token = $this->post('/api/user/login', [
            'username' => 'jaska',
            'password' => '123'
        ]);
        $token->assertStatus(200);
        $token = $token->json()['token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get('api/auth/user');

        $response->assertStatus(200);
    }

    public function test_user_update_qilish()
    {
        DB::beginTransaction();
        $token = $this->post('/api/user/login', [
            'username' => 'jaska',
            'password' => '123'
        ]);
        $token->assertStatus(200);
        $token = $token->json()['token'];

        $user = User::first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->put('api/user/update/' . $user->id, [
            'full_name' => $user->full_name,
            'password' => $user->password,
            'phone' => $user->phone,
        ]);

        $response->assertStatus(200);
        DB::rollBack();
    }

    private function generateRandomPhoneNumber()
    {
        return '+998 ' . rand(90, 91) . ' ' . rand(100, 999) . ' ' . rand(10, 99) . ' ' . rand(10, 99);
    }
}
