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


        'template' => "default",


        // used in account controller for creating character
        'player' => [
            "startStats" => [
                'level' => 8,
                'magiclevel' => 1,
                'cap' => 200,
                'health' => 1000,
                'mana' => 1000,
                'skill' => 35
            ],
            "vocations" => [
                'Sorcerer' => 1,
                'Druid' => 2,
                'Paladin' => 3,
                'Knight' => 4
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


        // all globals are sent to \config\packages\GLOBALS.php to be rendered(used in twig)
        'globals' => [
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
            'cities' => [
                "Thais" => 1,
                "Kazordoon" => 2,
                "Venore" => 3,
            ]
        ],



    ];



}

?>