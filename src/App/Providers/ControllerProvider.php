<?php

namespace App\Providers;

use Framework\Container\ContainerInterface;
use Framework\Container\ServiceProviderInterface;

class ControllerProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container): void
    {
        $container->bind(
            'App\UI\Controller\IndexController', 
            fn($c) => new \App\UI\Controller\IndexController(
                $c->get('App\Application\Service\GetPostsService')
            )
        );

        $container->bind(
            'App\UI\Controller\PostController', 
            fn($c) => new \App\UI\Controller\PostController(
                $c->get('App\Application\Service\GetSinglePostService')
            )
        );
    }
}