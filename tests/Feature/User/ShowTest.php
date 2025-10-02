<?php

namespace Tests\Feature\User;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    const ROUTE = 'users.show';

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
            ->getJson(route(self::ROUTE, 0));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_success(): void
    {
        $response = $this->actingAsSanctum()->getJson(route(self::ROUTE, $this->user->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
