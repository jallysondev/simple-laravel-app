<?php

namespace Tests\Feature\User;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    const ROUTE = 'users.update';

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
            ->putJson(route(self::ROUTE, 0), [
                'name' => 123,
                'password' => 123,
                'password_confirmation' => 123,
            ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_invalid_types_fail(): void
    {
        $response = $this
            ->actingAsSanctum()
            ->putJson(route(self::ROUTE, $this->user->id), [
                'name' => 123,
                'password' => 123,
                'password_confirmation' => 123,
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_success(): void
    {
        $response = $this->actingAsSanctum()->putJson(route(self::ROUTE, $this->user->id), [
            'name' => 'Test Update',
            'password' => '10203040',
            'password_confirmation' => '10203040',
        ]);

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

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Test Update',
        ]);
    }
}
