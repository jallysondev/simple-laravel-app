<?php

namespace Tests\Feature\User;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    const ROUTE = 'users.destroy';

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_it_fails_with_nonexistent_record(): void
    {
        $response = $this
            ->actingAsSanctum()
            ->deleteJson(route(self::ROUTE, 0));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_success(): void
    {
        $response = $this->actingAsSanctum()->deleteJson(route(self::ROUTE, $this->user->id));

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id,
        ]);
    }
}
