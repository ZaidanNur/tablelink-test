<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    /**
     * Get paginated list of users (excluding soft-deleted)
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUsers(int $perPage = 10): LengthAwarePaginator
    {
        return User::with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get a single user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return User::with('roles')->find($id);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data): User
    {
        $updateData = [];

        if (isset($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (isset($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        if (isset($data['password']) && !empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return $user->fresh('roles');
    }

    /**
     * Soft delete a user
     *
     * @param User $user
     * @param User $admin - The admin performing the deletion
     * @return bool
     * @throws ValidationException
     */
    public function deleteUser(User $user, User $admin): bool
    {
        // Prevent admin from deleting themselves
        if ($user->id === $admin->id) {
            throw ValidationException::withMessages([
                'user' => ['Admin cannot delete their own account.'],
            ]);
        }

        return $user->delete();
    }
}
