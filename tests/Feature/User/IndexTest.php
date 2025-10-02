<?php

namespace Tests\Feature\User;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    const ROUTE = 'users.index';

    protected function setUp(): void
    {
        parent::setUp();
        User::factory(10)->create();
    }

    public function test_success(): void
    {
        $response = $this->actingAsSanctum()->getJson(route(self::ROUTE));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }
}
