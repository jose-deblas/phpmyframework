<?php

namespace App\Domain\Repository;

use App\Domain\Model\PostId;
use App\Domain\Model\Post;

interface PostRepositoryInterface
{
    public function findAll(): array;
    public function findById(PostId $id): ?Post;
}
