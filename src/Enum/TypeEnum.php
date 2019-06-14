<?php

namespace App\Enum;

abstract class TypeEnum
{
    const GRASS = "grass";
    const BUG = "bug";
    const POISON = "poison";
    const FIRE = "fire";
    const WATER = "water";
    const ICE = "ice";
    const NORMAL = "normal";
    const DRAGON = "dragon";
    const FLIGHT = "flying";
    const ELECTRIC = "electric";
    const PSYCHIC = "psychic";
    const FIGHTING = "fighting";
    const GHOST = "ghost";
    const ROCK = "rock";
    const GROUND = "ground";

    protected static $typeName = [
        self::GRASS => "Plante",
        self::BUG => "Insecte",
        self::POISON => "Poison",
        self::FIRE => "Feu",
        self::WATER => "Eau",
        self::ICE => "Glace",
        self::NORMAL => "Normal",
        self::DRAGON => "Dragon",
        self::FLIGHT => "Vol",
        self::ELECTRIC => "Electrik",
        self::PSYCHIC => "Psy",
        self::FIGHTING => "Combat",
        self::GHOST => "Spectre",
        self::ROCK => "Roche",
        self::GROUND => "Sol",
    ];

    /**
     * @param string $shortName
     * @return string
     */
    public static function getTypeName($shortName)
    {
        if (!isset(static::$typeName[$shortName])) {
            return "Unknown type ($shortName)";
        }

        return static::$typeName[$shortName];
    }

    /**
     * @param bool $nullWanted
     * @return array<string>
     */
    public static function getAvailableTypes($nullWanted = true)
    {
        $types = [
            self::GRASS,
            self::BUG,
            self::POISON,
            self::FIRE,
            self::WATER,
            self::ICE,
            self::NORMAL,
            self::DRAGON,
            self::FLIGHT,
            self::ELECTRIC,
            self::PSYCHIC,
            self::FIGHTING,
            self::GHOST,
            self::ROCK,
            self::GROUND
        ];
        if($nullWanted)
            $types[] = null;

        return $types;
    }

    /**
     * @param string $lang
     * @return array<string>
     */
    public static function getTypeLabels($lang = 'fr'){
        return [
            'Plante',
            'Insecte',
            'Poison',
            'Feu',
            'Eau',
            'Glace',
            'Normal',
            'Dragon',
            'Vol',
            'Electrik',
            'Psy',
            'Combat',
            'Spectre',
            'Roche',
            'Sol'
        ];
    }
}
