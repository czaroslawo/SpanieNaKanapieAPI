<?php

namespace Tests\Feature\Auth;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{

    use RefreshDatabase;

    public function test_logout_user(){
        $user = User::create([
            'name' => 'Constantin',
            'email' => 'druc@pinsmile.com',
            'password' => bcrypt('password')
        ]);

        $token = $user->createToken("token")->plainTextToken;

        $response = $this->post('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }


}
