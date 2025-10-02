<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function __construct(
        protected readonly User $user
    ) {}

    public function create(array $data): User
    {
        return $this->user->create($data);
    }

    public function update(User $user, array $validatedData): User
    {
        $user->update($validatedData);

        return $user->refresh();
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->user->paginate();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
