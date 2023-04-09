<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasPermissions;
use App\Models\User;



class UserService
{
    protected $userRepository;

    use HasPermissions;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {   
        return $this->userRepository->getAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function register($data)
    {
        $data['password'] = Hash::make($data['password']);
        
        $user = $this->userRepository->create($data);

        return $user;
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);
    }
}