<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\Admin;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $adminDetails): string
    {
        $admin = Admin::where('email', $adminDetails['email'])->first();

        if(!$admin || !Hash::check($adminDetails['password'], $admin->password)){
            throw new \Exception('Credenciais incorretas.', 401);
        }
     
        return $admin->createToken($admin->email)->plainTextToken;
    }

    public function logout(Request $request): bool
    {
        return $request->user()->currentAccessToken()->delete();
    }

    public function sendPasswordResetLink(array $email): string
    {
        $admin = Admin::where('email', $email)->first();

        if(!$admin){
            throw new \Exception('Nenhum administrador cadastrado com este email', 404);
        }

        $status = Password::sendResetLink($email);

        return $status;
    }

    public function resetPassword(array $resetDetails): string
    {
        $admin = Admin::where('email', $resetDetails['email'])->first();

        if(!$admin){
            throw new \Exception('Nenhum administrador cadastrado com este email', 404);
        }

        if(!Password::tokenExists($admin, $resetDetails['token'])){
            throw new \Exception('Nenhum token para este email foi encontrado.', 404);
        }

        $status = Password::reset($resetDetails, function (Admin $admin, string $password) {
            $admin->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $admin->save();

            event(new PasswordReset($admin));
        });

        return $status;
    }
}