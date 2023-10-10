<?php

namespace Tests\Feature;

use App\Models\User as EloquentUserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUserByIdTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_is_found_by_id()
    {
        $user = EloquentUserModel::factory()->create();

        $response = $this->get("/api/user/{$user->id}");

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }
}
