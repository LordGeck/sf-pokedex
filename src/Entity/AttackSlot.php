<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttackSlotRepository")
 */
class AttackSlot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="smallint")
     */
    private $gen;

    /**
     * @ORM\Column(type="integer")
     */
    private $attack_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $pokemon_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getGen(): ?int
    {
        return $this->gen;
    }

    public function setGen(int $gen): self
    {
        $this->gen = $gen;

        return $this;
    }

    public function getAttackId(): ?int
    {
        return $this->attack_id;
    }

    public function setAttackId(int $attack_id): self
    {
        $this->attack_id = $attack_id;

        return $this;
    }

    public function getPokemonId(): ?int
    {
        return $this->pokemon_id;
    }

    public function setPokemonId(int $pokemon_id): self
    {
        $this->pokemon_id = $pokemon_id;

        return $this;
    }
}
