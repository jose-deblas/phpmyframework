<?php

namespace Framework;

use Framework\Http\Request;
use Framework\Http\Response;

class Kernel
{
    private string $environment;
    private bool $debug;

    public function __construct(string $environment = 'dev', bool $debug = true)
    {
        $this->environment = $environment;
        $this->debug = $debug;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function isDebug(): bool
    {
        return $this->debug;
    }

    public static function handle(Request $request): Response
    {
        $uri = $request->getUrlPath();
        if ('/' === $uri) {
            $body = '<html><body><h1>Home Page</h1></body></html>';
            return new Response($body);
        } else {
            $body = '<html><body><h1>Page Not Found papi</h1></body></html>';
            return new Response($body, 404);
        }
    }
}
