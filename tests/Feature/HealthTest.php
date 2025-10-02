<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HealthTest extends TestCase
{
    const ROUTE = 'health';

    public function test_success(): void
    {
        $response = $this->getJson(route(self::ROUTE));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(['status' => 'ok']);
    }
}
