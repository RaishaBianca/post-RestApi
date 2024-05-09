<?php

declare(strict_types=1);

namespace App\Contracts\Services\UserService;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function get(string $name): Array;
    public function create(string $name, string $email, string $password): User;
    public function update(int $key, string $name): User;
    public function delete(int $key): void;
    public function login(string $email, string $password): Array;
}