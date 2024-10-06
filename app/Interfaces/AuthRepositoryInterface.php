<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AuthRepositoryInterface 
{
    public function login(array $adminDetails): string;
    public function logout(Request $request): bool;
    public function sendPasswordResetLink(array $email): void;
    public function resetPassword(array $resetDetails): string;
}