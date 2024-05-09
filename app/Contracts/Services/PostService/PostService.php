<?php

declare(strict_types=1);

namespace App\Contracts\Services\PostService;

use App\Models\Post;
use App\Models\User;
use App\Models\Postings;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Services\UserService\UserServiceInterface;

class PostService implements PostServiceInterface
{
    public function __construct(private Post $post, private Postings $posting, private User $user)
    {}

    public function all(): Array
    {
        $postCollection = $this->posting->with('post','user')->get();
        $posts = $postCollection->map(function ($posting) {
            return [
                'title' => $posting->post->title,
                'content' => $posting->post->content,
                'author' => $posting->user->name,
            ];
        })->all();
        return $posts;
    }

    public function search(string $title): Collection{
        return $this->post->where('title', 'like', "%$title%")->get();
    }

    public function create(int $key, string $title, string $content): Post
    {
        $post = $this->post->create([
            'title' => $title,
            'content' => $content,
        ]);

        $user = $this->user->find($key);
        if($user == null){
            throw new \Exception('User not found');
        }

        $posting = $this->posting->create([
            'post_id' => $post->id,
            'user_id' => $key,
        ]);

        return $post;
    }

    public function update(int $key, string $title, string $content): Post{
        $post = $this->post->find($key);
        if($post == null){
            throw new \Exception('Post not found');
        }

        if($title != null || $title != ''){
            $post->update([
                'title' => $title,
            ]);
        }

        if($content != null || $content != ''){
            $post->update([
                'content' => $content,
            ]);
        }

        return $post;
    }

    public function delete(int $key): void{
        $postings = $this->posting->where('post_id', $key)->get();
        foreach($postings as $posting){
            $posting->delete();
        }

        $post = $this->post->find($key);
        if($post == null){
            throw new \Exception('Post not found');
        }

        $post->delete();
    }
    public function getByAuthor(int $key): Array{
        $postings = $this->posting->where('user_id', $key)->get();
        $posts = $this->post->newQuery()->whereIn('id', $postings->pluck('post_id'))->get();
        $posts = $posts->map(function ($post) {
            return [
                'title' => $post->title,
                'content' => $post->content,
            ];
        })->all();
        return $posts;
    }
}