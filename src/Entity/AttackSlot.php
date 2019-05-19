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
     * @ORM\ManyToOne(targetEntity="App\Entity\Pokemon", inversedBy="attackSlots")
     * @ORM\JoinColumn(
     *     name="pokemon_id",
     *     referencedColumnName="id",
     *     onDelete="CASCADE",
     *     nullable=false
     * )
     */
    private $pokemon;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Attack", inversedBy="attackSlots")
     * @ORM\JoinColumn(
     *     name="attack_id",
     *     referencedColumnName="id",
     *     onDelete="CASCADE",
     *     nullable=false
     * )
     */
    private $attack;

    /**
     * @ORM\Column(type="string", length=255) 
     */
    private $attack_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $attack_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $no_pokedex;

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

    public function setAttackCode($attack_code): self
    {
            $this->attack_code = $attack_code;
            return $this;
    }

    public function getAttackCode(): ?string
    {
        return $this->attack_code;
    }

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getAttack(): ?Attack
    {
        return $this->attack;
    }

    public function setAttack(?Attack $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNoPokedex()
    {
        return $this->no_pokedex;
    }

    /**
     * @param mixed $no_pokedex
     */
    public function setNoPokedex($no_pokedex): void
    {
        $this->no_pokedex = $no_pokedex;
    }
}
