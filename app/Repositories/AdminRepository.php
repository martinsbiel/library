<?php

namespace App\Repositories;

use App\Interfaces\AdminRepositoryInterface;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface
{
    protected $admin;

    // model injection
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function getAllAdmins(): Collection
    {
        $admins = $this->admin->get();

        if(count($admins) === 0){
            throw new \Exception(__('admin.not_found'), 404);
        }

        return $admins;
    }

    public function getAdminById(int $adminId): Admin
    {
        $admin = $this->admin->find($adminId);

        if(!$admin){
            throw new \Exception(__('admin.not_found'), 404);
        }

        return $admin;
    }

    public function deleteAdmin(int $adminId): Admin
    {
        $admin = $this->admin->find($adminId);

        if(!$admin){
            throw new \Exception(__('admin.not_found'), 404);
        }

        $admin->delete();

        return $admin;
    }

    public function createAdmin(array $adminDetails): Admin
    {
        $data = [
            'name' => $adminDetails['name'],
            'email' => $adminDetails['email'],
            'password' => Hash::make($adminDetails['password'])
        ];

        $admin = $this->admin->create($data);

        return $admin;
    }

    public function updateAdmin(int $adminId, array $newDetails): Admin
    {
        $admin = $this->admin->find($adminId);

        if(!$admin){
            throw new \Exception(__('admin.not_found'), 404);
        }

        $admin->update($newDetails);

        return $admin;
    }

    public function changePassword(int $adminId, array $details): Admin
    {
        $admin = $this->admin->find($adminId);

        if(!$admin){
            throw new \Exception(__('admin.not_found'), 404);
        }

        if(!Hash::check($details['password'], $admin->password)){
            throw new \Exception(__('admin.change_pass_failed'), 403);
        }

        $admin->update([
            'password' => Hash::make($details['new_password'])
        ]);

        return $admin;
    }
}