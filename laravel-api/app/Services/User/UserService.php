<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        protected readonly UserRepository $userRepository
    ) {}

    public function create(array $validatedData): User
    {
        return $this->userRepository->create($validatedData);
    }

    public function update(User $user, array $validatedData): User
    {
        return $this->userRepository->update($user, $validatedData);
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->userRepository->getAll();
    }

    public function delete(User $user): void
    {
        $this->userRepository->delete($user);
    }
}
