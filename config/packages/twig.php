<?php

use App\Utils\Configs;

$container->loadFromExtension('twig', [
    'paths' => [
        '%kernel.project_dir%/templates/' . Configs::$config['template'],
    ],
    'globals' => [
        'loginHelper' => '@App\Utils\LoginHelper'
    ],
]);