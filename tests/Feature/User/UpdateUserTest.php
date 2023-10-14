<?php

namespace Tests\Feature\User;

use App\Models\User as EloquentUserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_is_updated()
    {
        $user = EloquentUserModel::factory()->create();

        $response = $this->put("/api/user/{$user->id}", $this->data());

        $response->assertStatus(200);
        $response->assertDontSee($user->name);
        $response->assertDontSee($user->email);

        $this->assertDatabaseHas('users', $this->data());
    }

    private function data()
    {
        return [
            'name' => 'Firstname Lastname',
            'email' => 'firstname.lastname@email.com',
        ];
    }
}
