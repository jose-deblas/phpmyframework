<?php

namespace Framework\Container;

class Container implements ContainerInterface
{
    private array $services = [];
    private array $factories = [];
    private array $singletons = [];
    private array $singletonInstances = [];

    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new \InvalidArgumentException("Service '{$id}' not found in the container.");
        }

        if (isset($this->singletonInstances[$id])) {
            return $this->singletonInstances[$id];
        }

        if (isset($this->singletons[$id])) {
            $this->singletonInstances[$id] = $this->singletons[$id]($this);
            return $this->singletonInstances[$id];
        }

        if (isset($this->factories[$id])) {
            return $this->factories[$id]($this);
        }

        return $this->services[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]) || isset($this->factories[$id]) || isset($this->singletons[$id]);
    }

    public function set(string $id, $service): void
    {
        $this->services[$id] = $service;
    }

    public function bind(string $id, callable $factory): void
    {
        $this->factories[$id] = $factory;
    }

    public function singleton(string $id, callable $factory): void
    {
        $this->singletons[$id] = $factory;
    }
}
