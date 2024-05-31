<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Services\PostService\PostServiceInterface;
use App\Contracts\Services\UserService\UserServiceInterface;

final class AuthController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService,
        PostServiceInterface $postService
    ) {
        $this->postService = $postService;
    }

    public function index(Request $request): JsonResponse
    {
        $name = $request->header('name');
        $users = $this->userService->get($name);
        return new JsonResponse(Auth::id(), Response::HTTP_OK);
        return new JsonResponse($users, Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $name = $request->header('name');
        $email = $request->header('email');
        $password = Hash::make($request->header('password'));

        $user = $this->userService->create($name, $email, $password);

        $token = $user->createToken('auth_token')->plainTextToken;

        return new JsonResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->format('d/m/Y H:i:s'),
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request): JsonResponse
    {
        $email = $request->header('email');
        $password = $request->header('password');

        [$user] = $this->userService->login($email, $password);

        $token = $user->createToken('auth_token')->plainTextToken;

        return new JsonResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->format('d/m/Y H:i:s'),
            'key' => $key,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], Response::HTTP_OK);
    }

    public function update(Request $request): JsonResponse
    {
        $key = Auth::id();
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
        $key = Auth::id();
        $this->userService->delete($key);

        return new JsonResponse([
            'message'=> 'User deleted successfully'
        ], Response::HTTP_OK);
    }

    public function getByAuthor(Request $request): JsonResponse
    {

        $name = $request->header('name');
        $posts = $this->postService->getByAuthor($name);

        if(empty($posts)){
            return new JsonResponse(['message' => 'No user or post found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($posts, Response::HTTP_OK);
    }

    public function indexpost(Request $request): JsonResponse
    {
        $postings = $this->postService->all();

        return new JsonResponse($postings, Response::HTTP_OK);
    }

    public function search(Request $request): JsonResponse
    {
        $title = $request->header('title');
        $posts = $this->postService->search($title);

        return new JsonResponse($posts, Response::HTTP_OK);
    }

    public function createpost(Request $request): JsonResponse
    {
        $key = Auth::id();
        $title = $request->header('title');
        $content = $request->header('content');

        $post = $this->postService->create($key, $title, $content);

        return new JsonResponse([
            'message' => 'Post created successfully',
            'title' => $post->title,
            'content' => $post->content,
        ], Response::HTTP_CREATED);
    }

    public function updatepost(Request $request): JsonResponse
    {
        $key = $request->header('postKey');
        $title = $request->header('title', '');
        $content = $request->header('content','');

        $post = $this->postService->update($key, $title, $content);

        return new JsonResponse([
            'message' => 'Post updated successfully',
            'title' => $post->title,
            'content' => $post->content,
        ], Response::HTTP_OK);
    }

    public function deletepost(Request $request): JsonResponse
    {
        $key = $request->header('postKey');
        $this->postService->delete($key);

        return new JsonResponse(['message' => 'Post deleted successfully'], Response::HTTP_OK);
    }
}
