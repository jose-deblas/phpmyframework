<?php

namespace App\Domain\Model;

class Post
{
    private PostId $id;
    private string $title;
    private string $content;

    public function __construct(PostId $id, string $title, string $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }

    public function getId(): PostId
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getId(),
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            new PostId($data['id']),
            $data['title'],
            $data['content']
        );
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function getNumericId(): int
    {
        return $this->id->getId();
    }
}
