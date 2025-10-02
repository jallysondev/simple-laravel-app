<?php

namespace Tests\Feature\User;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ExternalOrderTest extends TestCase
{
    const ROUTE = 'external';

    public function test_success(): void
    {
        Http::fake([
            config('services.mockservice.base_url').'/api/orders' => Http::response([
                [
                    'id' => 1,
                    'product' => 'Product 1',
                    'price' => 100,
                    'status' => 'paid',
                ],
                [
                    'id' => 2,
                    'product' => 'Product 2',
                    'price' => 200,
                    'status' => 'pending',
                ],
            ]),
        ]);

        $response = $this->actingAsSanctum()->getJson(route(self::ROUTE));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'product',
                    'price',
                    'status',
                ],
            ],
        ]);
    }
}
