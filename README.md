# PHPMyFramework

PHPMyFramework is a simple PHP request/response framework

## Install

You'll need [Docker](https://www.docker.com/)

```bash
git clone https://github.com/jose-deblas/phpmyframework.git
cd phpmyframework
make install
```

## How it works?

### Router

Use the config/routes.yaml to set up the Routes

```yaml
app_post_category:
    path:     /post/{id}/category/{category}
    controller: App\UI\Controller\PostController
    method: execute
```

### Container

Use the config/providers.php file to set up the array with all the Providers classes that you need registered in the container

```php
return [
    '\App\Providers\ControllerProvider',
    '\App\Providers\RepositoriesProvider'
];
```

Each container should implement the interface \Framework\Container\ServiceProviderInterface where is mandatory the function register

```php
class RepositoriesProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container): void
    {
        $container->bind(
            'App\Infrastructure\Persistence\PostRepository',
            fn() => new \App\Infrastructure\Persistence\PostRepository()
        );
    }
}
```
