<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Services\UserService\UserServiceInterface;

final class UserController extends Controller
{
    public function __construct(private readonly UserServiceInterface $userService)
    {}

    public function index(Request $request): JsonResponse
    {
        $name = $request->header('name');
        $users = $this->userService->get($name);
        return new JsonResponse($users, Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $name = $request->header('name');
        $email = $request->header('email');
        $password = $request->header('password');

        $user = $this->userService->create($name, $email, $password);

        return new JsonResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->format('d/m/Y H:i:s')
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request): JsonResponse
    {
        $email = $request->header('email');
        $password = $request->header('password');

        [$user, $key] = $this->userService->login($email, $password);

        return new JsonResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->format('d/m/Y H:i:s'),
            'key' => $key
        ], Response::HTTP_OK);
    }

    public function update(Request $request): JsonResponse
    {
        $key = $request->header('key');
        $name = $request->header('name');

        $user = $this->userService->update($key, $name);

        return new JsonResponse([
            'message'=> 'User updated successfully',
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'updated_at' => $user->updated_at->format('d/m/Y H:i:s')
        ], Response::HTTP_OK);
    }

    public function delete(Request $request): JsonResponse
    {
        $key = $request->header('key');
        $this->userService->delete($key);

        return new JsonResponse([
            'message'=> 'User deleted successfully'
        ], Response::HTTP_OK);
    }
}
