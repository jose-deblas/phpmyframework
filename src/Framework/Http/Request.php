<?php

namespace Framework\Http;

class Request {
    private ParameterBag $query;        // $_GET
    private ParameterBag $request;      // $_POST
    private ParameterBag $attributes;   // Custom attributes
    private ParameterBag $cookies;      // $_COOKIE
    private ParameterBag $files;        // $_FILES
    private ServerBag $server;          // $_SERVER
    private HeaderBag $headers;         // HTTP Headers
    private mixed $content;             // Raw body content

    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        mixed $content = null
    ) {
        $this->initialize($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function getQuery(): ParameterBag {
        return $this->query;
    }

    public function getRequest(): ParameterBag {
        return $this->request;
    }

    public function getAttributes(): ParameterBag {
        return $this->attributes;
    }

    public function getCookies(): ParameterBag {
        return $this->cookies;
    }

    public function getFiles(): ParameterBag {
        return $this->files;
    }

    public function getServer(): ServerBag {
        return $this->server;
    }

    public function getHeaders(): HeaderBag {
        return $this->headers;
    }

    public function getContent(): mixed {
        return $this->content;
    }

    public function initialize(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        mixed $content = null
    ) {
        $this->query = new ParameterBag($query);
        $this->request = new ParameterBag($request);
        $this->attributes = new ParameterBag($attributes);
        $this->cookies = new ParameterBag($cookies);
        $this->files = new ParameterBag($files);
        $this->server = new ServerBag($server);
        $this->headers = new HeaderBag($this->server->getHeaders());
        $this->content = $content;
    }

    public function getUrlPath(): string {
        $uri = $this->server->get('REQUEST_URI', '/');
        $queryString = $this->server->get('QUERY_STRING', '');

        if ($queryString && str_contains($uri, '?')) {
            return substr($uri, 0, strpos($uri, '?'));
        }

        return $uri;
    }

    public static function createFromGlobals(): self {
        $query = $_GET;
        $request = $_POST;
        $content = null;
        
        $files = self::normalizeFilesStructure($_FILES);
        
        if (0 === strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json')) {
            $content = file_get_contents('php://input');
            $request = json_decode($content, true) ?? [];
        } else {
            $content = file_get_contents('php://input');
        }

        return new self(
            $query,
            $request,
            [],
            $_COOKIE,
            $files,
            $_SERVER,
            $content
        );
    }

    private static function normalizeFilesStructure(array $files): array {
        $normalized = [];

        foreach ($files as $key => $file) {
            if (is_array($file['name'])) {
                $normalized[$key] = [];
                foreach ($file['name'] as $index => $name) {
                    $normalized[$key][$index] = [
                        'name' => $name,
                        'type' => $file['type'][$index],
                        'tmp_name' => $file['tmp_name'][$index],
                        'error' => $file['error'][$index],
                        'size' => $file['size'][$index],
                    ];
                }
            } else {
                $normalized[$key] = $file;
            }
        }
        return $normalized;
    }

    public function addParamsInQuery(array $attributes): void {
        foreach ($attributes as $key => $value) {
            $this->query->set($key, $value);
        }
    }
}
