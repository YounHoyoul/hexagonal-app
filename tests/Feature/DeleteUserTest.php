<?php

namespace Tests\Feature;

use App\Models\User as EloquentUserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_is_deleted()
    {
        $user = EloquentUserModel::factory()->create();

        $this->delete("/api/user/{$user->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
