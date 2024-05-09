<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Contracts\Services\PostService\PostServiceInterface;

class PostController extends Controller
{
    public function __construct(private readonly PostServiceInterface $postService)
    {}

    public function index(Request $request): JsonResponse
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

    public function create(Request $request): JsonResponse
    {
        $key = $request->header('userKey');
        $title = $request->header('title');
        $content = $request->header('content');

        $post = $this->postService->create($key, $title, $content);

        return new JsonResponse([
            'message' => 'Post created successfully',
            'title' => $post->title,
            'content' => $post->content,
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request): JsonResponse
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

    public function delete(Request $request): JsonResponse
    {
        $key = $request->header('postKey');
        $this->postService->delete($key);

        return new JsonResponse(['message' => 'Post deleted successfully'], Response::HTTP_OK);
    }

    public function getByAuthor(Request $request): JsonResponse
    {
        $userKey = $request->header('userKey');
        $posts = $this->postService->getByAuthor($userKey);

        return new JsonResponse($posts, Response::HTTP_OK);
    }

}
