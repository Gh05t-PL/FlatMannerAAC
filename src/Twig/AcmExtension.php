<?php

namespace App\Twig;

use Extension\AbstractExtension;
use Twig\TwigFilter;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use \Twig_Function;

class AcmExtension extends \Twig_Extension
{
    public function getSesssion()
    {
        return $session = new Session();
    }

    public function getFunctions()
    {
        return array(
            'getSesssion' => new Twig_Function('getSesssion', [$this, 'getSesssion']),
        );
    }
}