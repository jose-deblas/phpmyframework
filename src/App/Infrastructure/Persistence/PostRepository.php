<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Model\Post;
use App\Domain\Model\PostId;
use App\Domain\Repository\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    private const JSON_FILE = __DIR__ . '/posts.json';

    public function findAll(): array
    {
        return $this->loadPosts();
    }

    public function findById(PostId $postId): ?Post
    {
        $posts = $this->loadPosts();
        return $posts[$postId->getId()] ?? null;
    }

    private function loadPosts(): array
    {
        if (!file_exists(self::JSON_FILE)) {
            return [];
        }

        $json = file_get_contents(self::JSON_FILE);
        $data = json_decode($json, true);

        $posts = [];
        foreach ($data as $item) {
            $post = Post::fromArray($item);
            $posts[$post->getNumericId()] = $post;
        }

        return $posts;
    }
}
