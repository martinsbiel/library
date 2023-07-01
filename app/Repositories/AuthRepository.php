<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $adminDetails)
    {
        $admin = Admin::where('email', $adminDetails['email'])->first();

        if(!$admin || !Hash::check($adminDetails['password'], $admin->password)){
            throw ValidationException::withMessages([
                'email' => ['Credenciais incorretas.'],
            ]);
        }
     
        return $admin->createToken($admin->email)->plainTextToken;
    }

    public function logout($request)
    {
        return $request->user()->currentAccessToken()->delete();
    }
}