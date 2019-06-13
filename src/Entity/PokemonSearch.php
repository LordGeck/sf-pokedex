<?php

namespace App\Entity;

class PokemonSearch
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $type1;

    /**
     * @var string|null
     */
    private $type2;

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return PokemonSearch
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType1(): string
    {
        return $this->type1;
    }

    /**
     * @param string|null $type1
     * @return PokemonSearch
     */
    public function setType1($type1): PokemonSearch
    {
        $this->type1 = $type1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType2(): string
    {
        return $this->type2;
    }

    /**
     * @param string|null $type2
     * @return PokemonSearch
     */
    public function setType2($type2): PokemonSearch
    {
        $this->type2 = $type2;
        return $this;
    }
}

