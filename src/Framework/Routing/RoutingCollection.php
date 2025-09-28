<?php

namespace Framework\Routing;

class RoutingCollection
{
    private array $routes;

    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    public function addRoute(string $path, array $handler): void
    {
        $this->routes[$path] = $handler;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function match(string $path): ?array
    {
        return $this->routes[$path] ?? null;
    }
}
