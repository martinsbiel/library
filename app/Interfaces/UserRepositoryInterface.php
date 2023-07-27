<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface 
{
    public function getAllUsers(): Collection;
    public function getUserById(int $userId): Collection;
    public function deleteUser(int $userId): User;
    public function createUser(array $userDetails): User;
    public function updateUser(int $userId, array $newDetails): User;
}