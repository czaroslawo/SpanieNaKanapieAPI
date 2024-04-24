<?php

namespace Tests\Feature\Auth;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{

    use RefreshDatabase;

    public function test_register_new_user(){
        $response = $this->post('/api/register', [
            'name' => 'Constantin Druc',
            'email' => 'druc@pinsmile.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSuccessful();
        $this->assertNotEmpty($response->getContent());
        $this->assertDatabaseHas('users', ['email' => 'druc@pinsmile.com']);
        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'token']);
    }


}
