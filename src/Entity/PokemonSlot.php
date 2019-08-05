<?php

namespace App\Entity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PokemonSlotRepository")
 */
class PokemonSlot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pokemonSlots")
     * @ORM\JoinColumn(
     *     name="user_id",
     *     referencedColumnName="id",
     *     onDelete="CASCADE",
     *     nullable=false
     * )
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pokemon", inversedBy="pokemonSlots")
     * @ORM\JoinColumn(
     *     name="pokemon_id",
     *     referencedColumnName="id",
     *     onDelete="CASCADE",
     *     nullable=false
     * )
     */
    private $pokemon;

    /**
     * @var
     */
    private $userId;

    /**
     * @ORM\Column(type="integer")
     */
    private $iv;

    /**
     * @ORM\Column(type="integer")
     */
    private $ev;

    /**
     * @ORM\Column(type="integer")
     */
    private $newAtk;

    /**
     * @ORM\Column(type="integer")
     */
    private $newDef;

    /**
     * @ORM\Column(type="integer")
     */
    private $newSpe;

    /**
     * @ORM\Column(type="integer")
     */
    private $newSpeed;

    /**
     * @ORM\Column(type="integer")
     */
    private $newHp;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return PokemonSlot
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return PokemonSlot
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPokemon()
    {
        return $this->pokemon;
    }

    /**
     * @param mixed $pokemon
     * @return PokemonSlot
     */
    public function setPokemon($pokemon)
    {
        $this->pokemon = $pokemon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIv()
    {
        return $this->iv;
    }

    /**
     * @param mixed $iv
     * @return PokemonSlot
     */
    public function setIv($iv)
    {
        $this->iv = $iv;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEv()
    {
        return $this->ev;
    }

    /**
     * @param mixed $ev
     * @return PokemonSlot
     */
    public function setEv($ev)
    {
        $this->ev = $ev;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewAtk()
    {
        return $this->newAtk;
    }

    /**
     * @param mixed $newAtk
     * @return PokemonSlot
     */
    public function setNewAtk($newAtk)
    {
        $this->newAtk = $newAtk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewDef()
    {
        return $this->newDef;
    }

    /**
     * @param mixed $newDef
     * @return PokemonSlot
     */
    public function setNewDef($newDef)
    {
        $this->newDef = $newDef;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewSpe()
    {
        return $this->newSpe;
    }

    /**
     * @param mixed $newSpe
     * @return PokemonSlot
     */
    public function setNewSpe($newSpe)
    {
        $this->newSpe = $newSpe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewSpeed()
    {
        return $this->newSpeed;
    }

    /**
     * @param mixed $newSpeed
     * @return PokemonSlot
     */
    public function setNewSpeed($newSpeed)
    {
        $this->newSpeed = $newSpeed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewHp()
    {
        return $this->newHp;
    }

    /**
     * @param mixed $newHp
     * @return PokemonSlot
     */
    public function setNewHp($newHp)
    {
        $this->newHp = $newHp;
        return $this;
    }
}
