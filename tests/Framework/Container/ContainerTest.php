<?php

use PHPUnit\Framework\TestCase;

use Framework\Container\Container;

class ContainerTest extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        $this->container = new Container();
    }

    public function testContainerSetService()
    {
        //Services: Pre-instantiated, always same value
        $service = new DateTime();
        $this->container->set('test_service', $service);

        $this->assertTrue($this->container->has('test_service'));
        $this->assertSame($service, $this->container->get('test_service'));
    }

    public function testContainerHasFlag()
    {
        $this->container->set('existent_service', new stdClass());
        $this->container->bind('existent_factory', fn() => new stdClass());
        $this->container->singleton('existent_singleton', fn() => new stdClass());

        $this->assertTrue($this->container->has('existent_service'));
        $this->assertTrue($this->container->has('existent_factory'));
        $this->assertTrue($this->container->has('existent_singleton')); 
        $this->assertFalse($this->container->has('non_existent_service'));
    }

    public function testContainerBindFactory()
    {
        //Factories: New instance each time
        $this->container->bind('empty_factory', fn() => new stdClass());

        $this->assertTrue($this->container->has('empty_factory'));
        $this->assertInstanceOf(stdClass::class, $this->container->get('empty_factory'));
        $this->assertNotSame(
            $this->container->get('empty_factory'),
            $this->container->get('empty_factory')
        );
    }

    public function testContainerSingleton()
    {
        //Singletons: Same instance each time
        $this->container->singleton('singleton_service', fn() => new stdClass());

        $this->assertTrue($this->container->has('singleton_service'));

        $instance1 = $this->container->get('singleton_service');
        $instance2 = $this->container->get('singleton_service');

        $this->assertSame($instance1, $instance2);
    }
}