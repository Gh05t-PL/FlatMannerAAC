<?php

namespace App\Utils;


class Configs
{

    static $config = [
        /**
         * AVAILABLE VERSIONS
         *
         * "0.4"
         * "1.2"
         *
         */
        'version' => "0.4",
        'dir' => "C:\Users\wiktor\Desktop\OTS\ots2",


        'template' => "thora",

        'news' => [
            'resultLimit' => 5,
        ],
        // used in account controller for creating character
        'player' => [
            "startStats" => [
                'level' => 8,
                'magiclevel' => 1,
                'cap' => 200,
                'health' => 150,
                'mana' => 150,
                'skill' => 10,
            ],
            "vocations" => [
                'Sorcerer' => 1,
                'Druid' => 2,
                'Paladin' => 3,
                'Knight' => 4,
            ],
            "cities" => [
                "Thais" => 1,
                "Kazordoon" => 2,
                "Venore" => 3,
            ],
            "citiesPos" => [
                1 => [
                    "x" => 95,
                    "y" => 126,
                    "z" => 7,
                ],
                2 => [
                    "x" => 201,
                    "y" => 497,
                    "z" => 7,
                ],
            ],
        ],


        // all globals are passed to \config\packages\GLOBALS.php to be rendered(used in twig)
        'globals' => [
            'powerGamers' => false,
            'vocations' => [
                0 => "None",
                1 => "Sorcerer",
                2 => "Druid",
                3 => "Paladin",
                4 => "Knight",
                5 => "Master Sorcerer",
                6 => "Elder Druid",
                7 => "Royal Paladin",
                8 => "Elite Knight",
            ],
            'otsName' => "OTSNAME",
            'aboutServer' => "",
            'cities' => [
                "Thais" => 1,
                "Kazordoon" => 2,
                "Venore" => 3,
            ],
        ],


    ];


}

?>