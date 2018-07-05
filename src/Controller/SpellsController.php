<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Utils\Configs;

class SpellsController extends Controller
{
    /**
     * @Route("/spells/{vocName}", name="spells")
     */
    public function index($vocName = "All")
    {
        // if ( $vocName !== "all" )
        // {
            $vocations = file_get_contents('vocations.xml');
            $vocations = new \SimpleXMLElement($vocations);

            $vocationsArr = [];
            $vocationsArr['All'] = 'All';
            foreach ($vocations->vocation as $key => $value) {

                if ( !\array_key_exists((string)$value['name'], $vocationsArr) )
                {
                    $vocationsArr[(string)$value['name']] = [(int)$value['id']];
                }
                else {
                    $vocationsArr[(string)$value['name']][] = (int)$value['id'];
                }
                
            }

            $vocations = null;

            
            
            $spells = file_get_contents('spells.xml');
            $spells = new \SimpleXMLElement($spells);

            $instantSpells = [];
            if ( $vocName !== "All" )
            {
                foreach ($spells->instant as $key => $spell) 
                {
                    /* if ( empty($spell->vocation) && (int)$spell->vocation[0]['id'] !== 0  )*/
                    if ( !isset($spell->vocation) )
                    {
                        $instantSpells[] = [
                            'vocations' => $vocName,
                            'name' => $spell['name'],
                            'words' => $spell['words'],
                            'level' => $spell['lvl'],
                            'mana' => $spell['mana'],
                            'prem' => (int)$spell['prem'],
                        ];
                        continue;
                    }
                    foreach ($spell->vocation as $key2 => $vocation) {
                        $matches = null;
                        if ( \preg_match('/(\d*)-(\d*)/', $spell->vocation['id'], $matches) == 1 )
                        {
                            if ( (\array_search($matches[1], $vocationsArr[$vocName]) || \array_search($matches[2], $vocationsArr[$vocName])) !== false )
                            {
                                $instantSpells[] = [
                                    'vocations' => $vocName,
                                    'name' => $spell['name'],
                                    'words' => $spell['words'],
                                    'level' => $spell['lvl'],
                                    'mana' => $spell['mana'],
                                    'prem' => (int)$spell['prem'],
                                ];
                            }
                            break;
                            
                        }

                        if ( \array_search((int)$vocation['id'], $vocationsArr[$vocName]) !== false )
                        {
                            $instantSpells[] = [
                                'vocations' => $vocName,
                                'name' => $spell['name'],
                                'words' => $spell['words'],
                                'level' => $spell['lvl'],
                                'mana' => $spell['mana'],
                                'prem' => (int)$spell['prem'],
                            ];
                            break;
                        }
                    }
                }

                return $this->render('spells/index.html.twig', [
                    'controller_name' => 'SpellsController',
                    'instantSpells' => $instantSpells,
                    'vocationss' => $vocationsArr,
                    'vocName' => $vocName,
                ]);
            }
            else
            {
                foreach ($spells->instant as $key => $spell) 
                {
                    /* if ( empty($spell->vocation) && (int)$spell->vocation[0]['id'] !== 0  )*/
                    if ( !isset($spell->vocation) )
                    {
                        $instantSpells[] = [
                            'vocations' => $vocName,
                            'name' => $spell['name'],
                            'words' => $spell['words'],
                            'level' => $spell['lvl'],
                            'mana' => $spell['mana'],
                            'prem' => (int)$spell['prem'],
                        ];
                        continue;
                    }
                }

                return $this->render('spells/index.html.twig', [
                    'controller_name' => 'SpellsController',
                    'instantSpells' => $instantSpells,
                    'vocationss' => $vocationsArr,
                    'vocName' => $vocName,
                ]);
            }

    }
}
