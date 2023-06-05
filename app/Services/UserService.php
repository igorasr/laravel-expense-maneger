<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function create($data)
    {

        $userAlreadyExists = User::where('email', $data['email'])
            ->Where('name', $data['name'])
            ->exists();

        if ($userAlreadyExists)
            return array(
                'error' => true,
                'message' => [
                    'user' => 'User already exists'
                ]
            );

        $data['password'] = bcrypt($data['password']);

        return User::create($data);
    }
}
