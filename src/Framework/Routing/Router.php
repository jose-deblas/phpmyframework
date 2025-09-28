<?php

namespace Framework\Routing;

class Router
{
    private RoutingCollection $routes;

    public function __construct(RoutingCollection $routes)
    {
        $this->routes = $routes;
    }

    public static function loadCollection(RoutingCollection $collection): self
    {
        return new self($collection);
    }

    public function match(string $path): array
    {
        return $this->getExactMatch($path) ?? $this->getRegexMatch($path);
    }

    private function getExactMatch(string $path): ?array
    {
        $conficPath = $this->routes->match($path);
        if ($conficPath !== null) {
            return array_merge($conficPath, [null]);
        }

        return null;
    }

    private function getRegexMatch(string $path): array
    {
        $routePathsWithParams = $this->getRoutePathsWithParams();
        
        foreach ($routePathsWithParams as $pathWithParams) {
            $regex = $this->convertPathToRegex($pathWithParams);

            if (preg_match($regex, $path, $matches)) {
                array_shift($matches);
                
                // Extract parameter names from the route
                preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', $pathWithParams, $paramNames);
                $paramNames = $paramNames[1];

                // Combine parameter names with their corresponding values
                $params = array_combine($paramNames, $matches);

                [$controller, $method] = $this->routes->match($pathWithParams);
                return [$controller, $method, $params];
            }

        }

        return [null, null, null];
    }

    private function getRoutePathsWithParams(): array
    {
        $routePaths = array_keys($this->routes->getRoutes());
        return array_filter($routePaths, fn($p) => str_contains($p, '{'));
    }

    private function convertPathToRegex(string $path): string
    {
        $escapedPath = preg_quote($path, '/');
        $regex = preg_replace('/\\\{[a-zA-Z_][a-zA-Z0-9_]*\\\}/', '([^\/]+)', $escapedPath);

        return '/^' . $regex . '$/';
    }
}
