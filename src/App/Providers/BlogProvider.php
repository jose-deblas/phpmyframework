<?php

namespace App\Providers;

use Framework\Container\ContainerInterface;
use Framework\Container\ServiceProviderInterface;

class BlogProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container): void
    {
        $container->bind(
            'App\Infrastructure\Persistence\PostRepository',
            fn() => new \App\Infrastructure\Persistence\PostRepository()
        );

        $container->bind(
            'App\Application\Service\GetPostsService',
            fn($c) => new \App\Application\Service\GetPostsService(
                $c->get('App\Infrastructure\Persistence\PostRepository')
            )
        );

        $container->bind(
            'App\Application\Service\GetSinglePostService',
            fn($c) => new \App\Application\Service\GetSinglePostService(
                $c->get('App\Infrastructure\Persistence\PostRepository')
            )
        );
    }

}
