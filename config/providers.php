<?php

return [
    '\App\Providers\ControllerProvider',
    '\App\Providers\BlogProvider'
];

/*
$factories = [
    'user_repository' => function($container) {
        return new \App\Repository\UserRepository($container->get('database_connection'));
    },
];

$singletons = [
    'config' => function() {
        return new \App\Config(['setting1' => 'value1', 'setting2' => 'value2']);
    },
];

return [
    'services' => $services,
    'factories' => $factories,
    'singletons' => $singletons,
];
*/
