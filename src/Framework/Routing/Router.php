<?php

namespace Framework\Routing;

class Router
{
    private RoutingCollection $routes;

    public function __construct(RoutingCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(string $path): array
    {
        return $this->routes->match($path) ?? [null, null];
    }

    public static function fromYamlConfig(): self
    {
        return new self(RoutingCollection::fromYamlConfig());
    }
}
