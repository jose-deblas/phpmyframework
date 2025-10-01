<?php

namespace Framework\Container;

Interface ServiceProviderInterface
{
    public function register(ContainerInterface $container): void;
}
