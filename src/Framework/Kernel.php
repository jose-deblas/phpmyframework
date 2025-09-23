<?php

namespace Framework;

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Routing\Router;

class Kernel
{
    private string $environment;
    private bool $debug;
    private bool $booted = false;
    private Router $router;

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

    public function handle(Request $request): Response
    {
        $this->boot();

        [$controllerClass, $method] = $this->router->match($request->getUrlPath());
        
        if (null === $controllerClass || null === $method) {
            return $this->notFoundResponse();
        }

        $controller = new $controllerClass();

        return $controller->$method($request);        
    }

    private function boot(): void
    {
        if ($this->booted) {
            return;
        }

        $this->initializeRoutes();
        
        $this->booted = true;
    }

    private function initializeRoutes(): void
    {
        $this->router = Router::fromYamlConfig();
    }

    private function notFoundResponse(): Response
    {
        $body = '<html><body><h1>404 Not Found</h1></body></html>';
        return new Response($body, 404);
    }
}
