<?php

namespace App\Domain\Model;

use InvalidArgumentException;

class PostId {
    private int $id;

    public function __construct(int $id) {
        if ($id <= 0) {
            throw new InvalidArgumentException("Post ID must be a positive integer.");
        }
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }
}
