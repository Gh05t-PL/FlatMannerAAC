<?php

use App\Utils\Configs;

$container->loadFromExtension('twig', array(
    'paths' => array(
        '%kernel.project_dir%/templates/' . Configs::$config['template'],
    ),
));