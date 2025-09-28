<?php

namespace App\Application\Service;

use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\Model\Post;

class GetPostsService
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return Post[]
     */
    public function execute(): array
    {
        return $this->postRepository->findAll();
    }
}
