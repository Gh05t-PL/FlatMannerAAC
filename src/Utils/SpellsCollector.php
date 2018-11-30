<?php
/**
 * Created by PhpStorm.
 * User: wiktor
 * Date: 19.11.2018
 * Time: 12:59
 */

namespace App\Utils;


class SpellsCollector
{
    private $XML;

    public function __construct($dir)
    {
        $this->XML = new \SimpleXMLElement($dir, 0, true);
    }

    public function getSpellsForVocation($vocationsArr, $vocName)
    {
        $instantSpells = [];
        foreach ($this->XML->instant as $key => $spell)
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

            foreach ($spell->vocation as $key2 => $vocation)
            {
                if ( \preg_match('/(\d*)-(\d*)/', $spell->vocation['id']) == 1 )
                {
                    foreach ($vocationsArr[$vocName] as $value)
                    {
                        if ( $this->isInRange($spell->vocation['id'], $value) )
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
                        //return $instantSpells;
                        break 2;
                    }

                } elseif ( \array_search((int)$vocation['id'], $vocationsArr[$vocName]) !== false )
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
        //var_dump($instantSpells);
        return $instantSpells;
    }

    public function getSpellsForAll($vocName)
    {
        $instantSpells = [];
        foreach ($this->XML->instant as $key => $spell)
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
        return $instantSpells;
    }

    /*
        private function processerFor1($spell, $vocationsArr, $vocName)
        {
            $instantSpells = [];
    //var_dump($vocationsArr[$vocName]);
            foreach ($spell->vocation as $key2 => $vocation)
            {
                $matches = null;

                if ( \preg_match('/(\d*)-(\d*)/', $vocation['id']) == 1 )
                {
                    foreach ($vocationsArr[$vocName] as $value)
                    {
                        if ( $this->isInRange($vocation['id'], $value) )
                        {
                            $instantSpells = [
                                'vocations' => $vocName,
                                'name' => $spell['name'],
                                'words' => $spell['words'],
                                'level' => $spell['lvl'],
                                'mana' => $spell['mana'],
                                'prem' => (int)$spell['prem'],
                            ];
                        }
                        return $instantSpells;
                        //break 2;
                    }


                }

                if ( \array_search((int)$vocation['id'], $vocationsArr[$vocName]) !== false )
                {
                    $instantSpells = [
                        'vocations' => $vocName,
                        'name' => $spell['name'],
                        'words' => $spell['words'],
                        'level' => $spell['lvl'],
                        'mana' => $spell['mana'],
                        'prem' => (int)$spell['prem'],
                    ];
                    return $instantSpells;
                    //break;
                }
            }
            //return $instantSpells;
            return 5;
        }
    */

    private function isInRange($range, $value)
    {
        $matches = null;
        \preg_match('/(\d*)-(\d*)/', $range, $matches);
        if ( $value >= (int)$matches[1] && $value <= (int)$matches[2] )
            return true;
        return false;
    }
}