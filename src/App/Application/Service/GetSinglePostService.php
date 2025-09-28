<?php

namespace App\Application\Service;

use App\Domain\Model\Post;
use App\Domain\Model\PostId;
use App\Domain\Repository\PostRepositoryInterface;

class GetSinglePostService
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(int $id): ?Post
    {
        return $this->postRepository->findById(new PostId($id));
    }
}