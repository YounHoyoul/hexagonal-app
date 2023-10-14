<?php

namespace Tests\Feature\User;

use App\Models\User as EloquentUserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_are_listed()
    {
        $users = EloquentUserModel::factory(10)->create();

        $response = $this->get('/api/user');

        $response->assertStatus(200);

        $response->assertSee($users->last()->name);
        $response->assertSee($users->last()->email);
    }
}
