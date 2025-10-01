<?php

namespace Framework\Container;

interface ContainerInterface
{
    public function get(string $id);
    public function has(string $id): bool;
    public function set(string $id, $service): void;
    public function bind(string $id, callable $factory): void;
    public function singleton(string $id, callable $singleton): void;
}