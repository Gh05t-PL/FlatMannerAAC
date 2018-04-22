<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;

// $session = new Session();
// var_dump( $session->get('account_id'));
// var_dump($session);

$container->loadFromExtension('twig', [
    'globals' => [
        'vocations' => [
            "None",
            "Sorcerer",
            "Druid",
            "Paladin",
            "Knight",
            "Master Sorcerer",
            "Elder Druid",
            "Royal Paladin",
            "Elite Knight",
        ],
    ],
]);