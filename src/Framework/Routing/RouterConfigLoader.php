<?php

namespace Framework\Routing;

class RouterConfigLoader
{
    public static function loadYaml(string $path): RoutingCollection
    {
        $yamlRoutes = yaml_parse_file($path);
        $routingCollection = new RoutingCollection();

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