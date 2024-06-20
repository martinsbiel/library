<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    // model injection
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUsers(): Collection
    {
        $users = $this->user->with('loans')->get();

        if(count($users) === 0){
            throw new \Exception(__('user.not_found'), 404);
        }

        return $users;
    }

    public function getUserById(int $userId): Collection
    {
        $user = $this->user->with('loans')->where('id', $userId)->get();

        if(count($user) === 0){
            throw new \Exception(__('user.not_found'), 404);
        }

        return $user;
    }

    public function deleteUser(int $userId): User
    {
        $user = $this->user->find($userId);

        if(!$user){
            throw new \Exception(__('user.not_found'), 404);
        }

        $user->delete();

        return $user;
    }

    public function createUser(array $userDetails): User
    {
        $user = $this->user->create($userDetails);

        return $user;
    }

    public function updateUser(int $userId, array $newDetails): User
    {
        $user = $this->user->find($userId);

        if(!$user){
            return response()->json(['error' => __('user.not_found')], 404);
        }

        $user->update($newDetails);

        return $user;
    }
}