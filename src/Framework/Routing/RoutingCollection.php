<?php

namespace Framework\Routing;

class RoutingCollection
{
    private const YAML_CONFIG_PATH = __DIR__ . '/../../../config/routes.yaml';
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

    public static function fromYamlConfig(): self
    {
        $routingCollection = new self();
        $yamlRoutes = yaml_parse_file(self::YAML_CONFIG_PATH);

        foreach ($yamlRoutes as $route) {
            if (isset($route['path'], $route['controller'], $route['method'])) {
                $routingCollection->addRoute(
                    $route['path'],
                    [
                        $route['controller'],
                        $route['method']
                    ]
                );
            }
        }

        return $routingCollection;
    }
}
