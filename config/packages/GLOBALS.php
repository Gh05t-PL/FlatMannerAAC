<?php

use App\Utils\Configs;

$container->loadFromExtension('twig', [
    'globals' => Configs::$config['globals']
]);