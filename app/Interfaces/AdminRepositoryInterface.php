<?php

namespace App\Interfaces;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryInterface 
{
    public function getAllAdmins(): Collection;
    public function getAdminById(int $adminId): Admin;
    public function deleteAdmin(int $adminId): Admin;
    public function createAdmin(array $adminDetails): Admin;
    public function updateAdmin(int $adminId, array $newDetails): Admin;
    public function changePassword(int $adminId, array $details): Admin;
}