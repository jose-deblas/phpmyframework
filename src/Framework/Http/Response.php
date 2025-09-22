<?php

namespace Framework\Http;

class Response {
    private int $statusCode;
    private array $headers;
    private string $body;

    public function __construct(string $body, int $statusCode = 200, array $headers = []) {
        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->headers = $headers ?? ['Content-Type' => 'text/html; charset=utf-8'];
    }

    public function send() {
        http_response_code($this->statusCode);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        echo $this->body;
    }
}
