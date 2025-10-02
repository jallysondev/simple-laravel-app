<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public function actingAsSanctum(?User $user = null): self
    {
        $user = $user ?: User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        return $this;
    }
}
