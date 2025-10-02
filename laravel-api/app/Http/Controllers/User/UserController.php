<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        protected readonly UserService $userService
    ) {}

    public function index()
    {
        try {
            return UserResource::collection($this->userService->getAll());
        } catch (Exception $exception) {
            Log::error(' FAILED TO LIST USERS ', [
                'error' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }

        return response()->json(['message' => 'Failed to list users. Please try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function store(CreateUserRequest $request): UserResource|JsonResponse
    {
        try {
            return UserResource::make($this->userService->create($request->validated()));
        } catch (Exception $exception) {
            Log::error(' FAILED TO CREATE USER ', [
                'error' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }

        return response()->json(['message' => 'Failed to create user. Please try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update(User $user, UpdateUserRequest $request): UserResource|JsonResponse
    {
        try {
            return UserResource::make($this->userService->update($user, $request->validated()));
        } catch (Exception $exception) {
            Log::error(' FAILED TO UPDATE USER ', [
                'error' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }

        return response()->json(['message' => 'Failed to update user. Please try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function show(User $user): UserResource|JsonResponse
    {
        try {
            return UserResource::make($user);
        } catch (Exception $exception) {
            Log::error(' FAILED TO DETAIL USER ', [
                'error' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }

        return response()->json(['message' => 'Failed to detail user. Please try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function destroy(User $user): Response
    {
        try {
            $this->userService->delete($user);

            return response()->noContent();
        } catch (Exception $exception) {
            Log::error(' FAILED TO DESTROY USER ', [
                'error' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }

        return response()->json(['message' => 'Failed to destroy user. Please try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
