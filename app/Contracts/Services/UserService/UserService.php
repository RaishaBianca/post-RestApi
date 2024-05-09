<?php

declare(strict_types=1);

namespace App\Contracts\Services\UserService;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Services\UserService\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function __construct(private User $user)
    {}

    public function get(string $name): Array
    {
        $users = $this->user->newQuery()->where('name', 'like', '%' . $name . '%')->get();
        $usersArray = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format(DateTimeInterface::ATOM),
            ];
        })->all();

        return $usersArray;
    }

    public function create(string $name, string $email, string $password): User
    {
        $this->user = $this->user->create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        return $this->user;
    }

    public function update(int $key, string $name): User
    {
        $user = $this->user->newQuery()->findOrFail($key);
        $user->update([
            'name' => $name,
        ]);

        return $user;
    }

    public function delete(int $key): void
    {
        $user = $this->user->find($key);
        if ($user) {
            $user->delete();
        } else {
            throw new \Exception('User not found');
        }
    }
    
    public function login(string $email, string $password): Array
    {
        $user = $this->user->newQuery()->where('email', $email)->first();
        if (!$user || !password_verify($password, $user->password)) {
            throw new \Exception('Invalid credentials');
        }
        $key = $user->id;
        return [$user, $key];
    }
}