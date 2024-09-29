<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
    function register(string $name, string $email, string $password): void;
    function login(string $email, string $password): bool;
    function getUserId(string $email): int;
    function getUser(int $userId): ?User;
    function updateUser(int $userId, ?string $name, ?string $email): void;
}
