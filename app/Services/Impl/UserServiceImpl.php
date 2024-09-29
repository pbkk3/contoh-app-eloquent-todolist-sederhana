<?php

namespace App\Services\Impl;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class UserServiceImpl implements UserService
{

    public function register(string $name, string $email, string $password): void
    {
        $userExists = User::query()->where("email", $email)->exists();

        if($userExists){
            throw new Exception("User already exists");
        }

        $user = new User([
            "name" => $name,
            "email" => $email,
            "password" => bcrypt($password)
        ]);

        $user->save();
    }

    function login(string $email, string $password): bool
    {
        return Auth::attempt([
            "email" => $email,
            "password" => $password
        ]);
    }

    public function getUserId(string $email): int
    {
        $user = User::query()->where("email", $email)->first();

        if($user == null){
            throw new Exception("User not found");
        }

        return $user->id;
    }

    public function getUser(int $userId): ?User
    {
        $user = User::query()->find($userId);

        if($user == null){
            throw new Exception("User not found");
        }

        return $user;
    }

    public function updateUser(int $userId, ?string $name, ?string $email): void
    {
        $user = User::query()->find($userId);

        if($user == null){
            throw new Exception("User not found");
        }

        $updateData = [];

        if($name != null){
            $updateData["name"] = $name;
        };

        if($email != null){
            $updateData["email"] = $email;
        };

        $user->update($updateData);
    }

}
