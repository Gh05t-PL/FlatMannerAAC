<?php
/**
 * Created by PhpStorm.
 * User: wiktor
 * Date: 22.11.2018
 * Time: 14:25
 */

namespace App\Utils;


class ConfigsParser
{
    private $file;

    public function __construct()
    {
        $this->file = file_get_contents(Configs::$config['dir'] . "/config.lua");
    }

    public function parse()
    {
        $pattern = "/(?:(\w*) *)= *([\w\*\-\+\/\"\'\,\:\@\\\.\!\? ]*)\n/m";
        $arrayTemp = [];
        \preg_match_all($pattern, $this->file, $arrayTemp, PREG_SET_ORDER);


        $array = [];
        foreach ($arrayTemp as $key => $value)
        {
            $array[$value[1]] = $value[2];
        }
        $array['configModTime'] = filemtime(Configs::$config['dir'] . "/config.lua");
//        $json = \json_encode($array);

        return $array;
    }

    public function save()
    {
        $array = $this->parse();
        file_put_contents("configss.json",json_encode($array));
    }


}