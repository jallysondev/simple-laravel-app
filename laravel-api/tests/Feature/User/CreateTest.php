<?php

namespace Tests\Feature\User;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{
    const ROUTE = 'users.store';

    public function test_required_fields_fail(): void
    {
        $response = $this
            ->actingAsSanctum()
            ->postJson(route(self::ROUTE));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_invalid_types_fail(): void
    {
        $response = $this
            ->actingAsSanctum()
            ->postJson(route(self::ROUTE), [
                'name' => 123,
                'email' => 123,
                'password' => 123,
                'password_confirmation' => 123,
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_email_already_exists_fails(): void
    {
        $user = User::factory()->create(['email' => 'example@test.com']);

        $response = $this->actingAsSanctum()->postJson(route(self::ROUTE), [
            'name' => 'Test User',
            'email' => $user->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_success(): void
    {
        $response = $this->actingAsSanctum()->postJson(route(self::ROUTE), [
            'name' => 'Test User',
            'email' => 'email@test.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

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
            'name' => 'Test User',
            'email' => 'email@test.com',
        ]);
    }
}
