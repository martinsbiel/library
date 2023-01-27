<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    // model injection
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUsers()
    {
        $users = $this->user->with('loans')->get();

        if(count($users) === 0){
            throw new \Exception('Nenhum usuário encontrado.', 404);
        }

        return $users;
    }

    public function getUserById($userId)
    {
        $user = $this->user->with('loans')->where('id', $userId)->get();

        if(count($user) === 0){
            throw new \Exception('Usuário não encontrado.', 404);
        }

        return $user;
    }

    public function deleteUser($userId)
    {
        $user = $this->user->find($userId);

        if(!$user){
            throw new \Exception('Usuário não encontrado.', 404);
        }

        $user->delete();

        return $user;
    }

    public function createUser(array $userDetails)
    {
        $user = $this->user->create($userDetails);

        return $user;
    }

    public function updateUser($userId, array $newDetails)
    {
        $user = $this->user->find($userId);

        if(!$user){
            return response()->json(['error' => 'Usuário não encontrado.'], 404);
        }

        $user->update($newDetails);

        return $user;
    }
}