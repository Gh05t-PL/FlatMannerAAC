<?php
/**
 * Created by PhpStorm.
 * User: wiktor
 * Date: 19.11.2018
 * Time: 12:50
 */

namespace App\Utils;


class VocationCollector
{
    private $XML;

    public function __construct($dir)
    {
        $this->XML = new \SimpleXMLElement($dir, 0, true);
    }


    public function getIdsOfSameVocationName()
    {
        $vocationsArr = [];
        $vocationsArr['All'] = 'All';
        foreach ($this->XML->vocation as $key => $value)
        {

            if ( !\array_key_exists((string)$value['name'], $vocationsArr) )
            {
                $vocationsArr[(string)$value['name']] = [(int)$value['id']];
            } else
            {
                $vocationsArr[(string)$value['name']][] = (int)$value['id'];
            }

        }
        return $vocationsArr;
    }

    public function getVocationsName()
    {
        $result = [];
        foreach ($this->XML->vocation as $key => $value)
        {
            $result[(string)$value['name']] = true;
        }
        return array_keys($result);
    }
}