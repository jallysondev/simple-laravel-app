<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\ExternalOrderResource;
use App\Services\Order\ExternalOrderService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ExternalOrderController extends Controller
{
    public function __construct(
        protected readonly ExternalOrderService $externalOrderService
    ) {}

    public function __invoke(): AnonymousResourceCollection|JsonResponse
    {
        try {
            return ExternalOrderResource::collection($this->externalOrderService->handle());
        } catch (Exception $exception) {
            Log::error(' FAILED TO LIST EXTERNAl ORDERS ', [
                'error' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }

        return response()->json(['message' => 'Failed to list external orders. Please try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
