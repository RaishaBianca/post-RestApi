<?php

declare(strict_types=1);

namespace App\Contracts\Services\PostService;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostServiceInterface
{
    public function all(): Array;
    public function search(string $title): Collection;
    public function create(int $key, string $title, string $content): Post;
    public function update(int $key, string $title, string $content): Post;
    public function delete(int $key): void;
    public function getByAuthor(int $key): Array;
}