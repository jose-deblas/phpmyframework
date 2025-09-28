<?php

namespace Framework;

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Routing\Router;
use Framework\Routing\RouterConfigLoader;

class Kernel
{
    private const YAML_CONFIG_PATH = __DIR__ . '/../../config/routes.yaml';
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

        prettyVarDump($request->getUrlPath());

        [$controllerClass, $method, $params] = $this->router->match($request->getUrlPath());

        if (null === $controllerClass || null === $method) {
            return $this->notFoundResponse();
        }

        if (null !== $params) {
            $request->addParamsInQuery($params);
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
        $this->router = Router::loadCollection(
            RouterConfigLoader::loadYaml(self::YAML_CONFIG_PATH)
        );
    }

    private function notFoundResponse(): Response
    {
        $body = '<html><body><h1>404 Not Foundddd</h1></body></html>';
        return new Response($body, 404);
    }
}
