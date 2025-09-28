<?php

use PHPUnit\Framework\TestCase;

use Framework\Routing\Router;
use Framework\Routing\RouterConfigLoader;
use Framework\Routing\RoutingCollection;

class RouterTest extends TestCase
{
    private RoutingCollection $routingCollection;

    public function setUp(): void
    {
        $this->routingCollection = RouterConfigLoader::loadYaml(__DIR__ . '/../../../config/routes.yaml');
    }

    public function testStaticRouteMatching()
    {
        $router = new Router($this->routingCollection);

        [$controller, $method] = $router->match('/');
        $this->assertEquals('App\UI\Controller\IndexController', $controller);
        $this->assertEquals('execute', $method);
    }

    public function testDynamicRouteMatching()
    {
        $router = new Router($this->routingCollection);

        [$controller, $method, $params] = $router->match('/post/123');

        $this->assertEquals('App\UI\Controller\PostController', $controller);
        $this->assertEquals('execute', $method);
        $this->assertEquals(['id' => 123], $params);
        
        [$controller, $method, $params] = $router->match('/post/123/category/technology');

        $this->assertEquals('App\UI\Controller\PostController', $controller);
        $this->assertEquals('execute', $method);
        $this->assertEquals(['id' => 123, 'category' => 'technology'], $params);
    }

    public function testRouterNoMatch()
    {
        $router = new Router($this->routingCollection);

        [$controller, $method, $params] = $router->match('/nonexistent');
        $this->assertNull($controller);
        $this->assertNull($method);
        $this->assertNull($params);

        [$controller, $method, $params] = $router->match('/post/123/');
        $this->assertNull($controller);
        $this->assertNull($method);
        $this->assertNull($params);
    }
}

function prettyVarDump($var)
{
    echo '<pre style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ccc;">';
    var_dump($var);
    echo '</pre>';
}