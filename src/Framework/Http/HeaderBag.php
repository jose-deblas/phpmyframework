<?php

namespace Framework\Http;

class HeaderBag {
    private array $headers = [];

    public function __construct(array $headers = []) {
        foreach ($headers as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function get(string $key, $default = null) {
        $key = strtolower($key);
        return $this->headers[$key] ?? $default;
    }

    public function set(string $key, $value) {
        $key = strtolower($key);
        $this->headers[$key] = $value;
    }

    public function all(): array {
        return $this->headers;
    }
}
