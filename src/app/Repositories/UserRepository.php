<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository 
{
    public function getAll()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function create($data)
    {
        return User::create($data);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}