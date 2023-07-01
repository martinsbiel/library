<?php

namespace App\Interfaces;

interface AuthRepositoryInterface 
{
    public function login(array $adminDetails);
    public function logout($request);
}