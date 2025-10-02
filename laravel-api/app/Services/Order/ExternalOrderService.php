<?php

namespace App\Services\Order;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ExternalOrderService
{
    public function handle(): Collection
    {
        $response = Http::get(config('services.mockservice.base_url').'/api/orders');

        return collect($response->json() ?? []);
    }
}
