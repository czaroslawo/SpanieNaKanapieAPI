<?php

namespace Tests\Feature\Auth;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    public function test_login_existing_user(){
        $user = User::create([
            'name' => 'Constantin Druc',
            'email' => 'druc@pinsmile.com',
            'password' => bcrypt('secret')
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertSuccessful();
        $this->assertNotEmpty($response->getContent());
        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'iphone',
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id
        ]);
    }

    public function test_get_user_from_token(){

        $user = User::create([
            'name' => 'Constantin Druc',
            'email' => 'druc@pinsmile.com',
            'password' => bcrypt('secret')
        ]);

        $token = $user->createToken('token')->plainTextToken;

        $response = $this->get('/api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertSuccessful();

        $response->assertJson(function ($json) {
            $json->where('email', 'druc@pinsmile.com')
                ->missing('password')
                ->etc();
        });

    }


}
