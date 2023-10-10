<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_new_user_is_created()
    {
        $response = $this->postJson('/api/user', $this->data());

        $response->assertStatus(201);
        $response->assertSee($this->data()['name']);
        $response->assertSee($this->data()['email']);

        $this->assertDatabaseHas('users', [
            'name' => 'Firstname Lastname',
            'email' => 'firstname.lastname@email.com',
        ]);
    }

    private function data()
    {
        return [
            'name' => 'Firstname Lastname',
            'email' => 'firstname.lastname@email.com',
            'password' => 'password',
        ];
    }
}
