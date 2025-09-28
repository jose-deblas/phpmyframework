<?php

use PHPUnit\Framework\TestCase;

use Framework\Routing\RoutingCollection;

class RoutingCollectionTest extends TestCase
{
    private RoutingCollection $routingCollection;

    public function setUp(): void
    {
        $this->routingCollection = new RoutingCollection();
    }

    public function testRoutingCollectionAddRoute(): void
    {
        $this->routingCollection->addRoute('/test', ['TestController', 'testMethod']);
        $this->routingCollection->addRoute('/index', ['TestIndexController', 'testIndexMethod']);

        $this->assertEquals(
            ['TestController', 'testMethod'],
            $this->routingCollection->match('/test')
        );

        $this->assertEquals(
            ['TestIndexController', 'testIndexMethod'],
            $this->routingCollection->match('/index')
        );
    }

    public function testRoutingCollectionGetRoutes(): void
    {
        $this->assertIsArray($this->routingCollection->getRoutes());

        $this->routingCollection->addRoute('/test', ['TestController', 'testMethod']);
        $this->routingCollection->addRoute('/index', ['TestIndexController', 'testIndexMethod']);

        $routes = $this->routingCollection->getRoutes();
        $this->assertEquals(
            [
                '/test' => ['TestController', 'testMethod'],
                '/index' => ['TestIndexController', 'testIndexMethod'],
            ],
            $routes
        );
    }

    public function testRoutingCollectionMatch(): void
    {
        $this->routingCollection->addRoute('/test', ['TestController', 'testMethod']);
        $route = $this->routingCollection->match('/test');
        $this->assertNotNull($route);
        $this->assertEquals(['TestController', 'testMethod'], $route);

        $route = $this->routingCollection->match('/notexist');
        $this->assertNull($route);
    }
}
