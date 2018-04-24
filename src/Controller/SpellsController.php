<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SpellsController extends Controller
{
    /**
     * @Route("/spells", name="spells")
     */
    public function index()
    {
        $vocations = file_get_contents('vocations.xml');
        $vocations = new \SimpleXMLElement($vocations);

        $vocationsArr = [];
        foreach ($vocations->vocation as $key => $value) {
           //echo $value['id'].'   '.$value['name'];
           $vocationsArr[(int)$value['id']] = $value['name'];
        }
        //var_dump($vocationsArr);
        
        $spells = file_get_contents('spells.xml');
        $spells = new \SimpleXMLElement($spells);
        $instantSpells = [];
        foreach ($spells->instant as $key => $value) {
            $name = "";
            for ($i=0; $i < count($value->vocation); $i++) { 
                
                if ($i == 0)
                    $name .= $vocationsArr[(int)$value->vocation[$i]['id']];
                else
                $name .= ", ".$vocationsArr[(int)$value->vocation[$i]['id']];
                
                
            }
            $instantSpells[] = [
                'vocations' => $name,
                'name' => $value['name'],
                'words' => $value['words'],
                'level' => $value['lvl'],
                'mana' => $value['mana'],
                'prem' => (int)$value['prem'],
            ];
            
        }
        //var_dump($instantSpells);
        //var_dump( $spells->instant[0]['name']);
        return $this->render('spells/index.html.twig', [
            'controller_name' => 'SpellsController',
            'instantSpells' => $instantSpells,
        ]);
    }
}
