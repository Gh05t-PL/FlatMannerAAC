<?php

namespace App\Controller;

use App\Utils\Configs;
use App\Utils\SpellsCollector;
use App\Utils\VocationCollector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SpellsController extends Controller
{
    /**
     * @Route("/spells/{vocName}", name="spells")
     */
    public function index($vocName = "All")
    {

        $vocations = new VocationCollector(Configs::$config['dir'] . "/data/XML/" . "vocations.xml");
        $vocationsArr = $vocations->getIdsOfSameVocationName();
        $vocations = null;
        $spells = new SpellsCollector(Configs::$config['dir'] . "/data/spells/" . "spells.xml");

        $instantSpells = [];
        if ( $vocName !== "All" )
        {
            $instantSpells = $spells->getSpellsForVocation($vocationsArr, $vocName);
            //var_dump($instantSpells[0]);
            return $this->render('spells/index.html.twig', [
                'controller_name' => 'SpellsController',
                'instantSpells' => $instantSpells,
                'vocationss' => $vocationsArr,
                'vocName' => $vocName,
            ]);
        } else
        {
            $instantSpells = $spells->getSpellsForAll($vocName);

            return $this->render('spells/index.html.twig', [
                'controller_name' => 'SpellsController',
                'instantSpells' => $instantSpells,
                'vocationss' => $vocationsArr,
                'vocName' => $vocName,
            ]);
        }

    }
}
