<?php

namespace App\Interfaces;

interface AuthRepositoryInterface 
{
    public function login(array $adminDetails);
    public function logout($request);
    public function sendPasswordResetLink($email);
    public function resetPassword($resetDetails);
}