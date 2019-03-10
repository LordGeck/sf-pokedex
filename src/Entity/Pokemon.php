<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PokemonRepository")
 */
class Pokemon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $no_pokedex;

    /**
     * @ORM\Column(type="integer")
     */
    private $hp;

    /**
     * @ORM\Column(type="integer")
     */
    private $atk;

    /**
     * @ORM\Column(type="integer")
     */
    private $def;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $spe;

    /**
     * @ORM\Column(type="integer")
     */
    private $speed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type2;

    /**
     * @ORM\Column(type="float")
     */
    private $size;

    /**
     * @ORM\Column(type="float")
     */
    private $weight;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttackSlot", mappedBy="pokemon")
     */
    private $attackSlots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Description", mappedBy="pokemon")
     */
    private $descriptions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->attackSlots = new ArrayCollection();
        $this->descriptions = new ArrayCollection();
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoPokedex(): ?int
    {
        return $this->no_pokedex;
    }

    public function setNoPokedex(int $no_pokedex): self
    {
        $this->no_pokedex = $no_pokedex;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    public function getAtk(): ?int
    {
        return $this->atk;
    }

    public function setAtk(int $atk): self
    {
        $this->atk = $atk;

        return $this;
    }

    public function getDef(): ?int
    {
        return $this->def;
    }

    public function setDef(int $def): self
    {
        $this->def = $def;

        return $this;
    }

    public function getSpe(): ?int
    {
        return $this->spe;
    }

    public function setSpe(?int $spe): self
    {
        $this->spe = $spe;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getType1(): ?string
    {
        return $this->type1;
    }

    public function setType1(string $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Collection|AttackSlot[]
     */
    public function getAttackSlots(): Collection
    {
        return $this->attackSlots;
    }

    public function addAttackSlot(AttackSlot $attackSlot): self
    {
        if (!$this->attackSlots->contains($attackSlot)) {
            $this->attackSlots[] = $attackSlot;
            $attackSlot->setPokemon($this);
        }

        return $this;
    }

    public function removeAttackSlot(AttackSlot $attackSlot): self
    {
        if ($this->attackSlots->contains($attackSlot)) {
            $this->attackSlots->removeElement($attackSlot);
            // set the owning side to null (unless already changed)
            if ($attackSlot->getPokemon() === $this) {
                $attackSlot->setPokemon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Description[]
     */
    public function getDescriptions(): Collection
    {
        return $this->descriptions;
    }

    public function addDescription(Description $description): self
    {
        if (!$this->descriptions->contains($description)) {
            $this->descriptions[] = $description;
            $description->setPokemon($this);
        }

        return $this;
    }

    public function removeDescription(Description $description): self
    {
        if ($this->descriptions->contains($description)) {
            $this->descriptions->removeElement($description);
            // set the owning side to null (unless already changed)
            if ($description->getPokemon() === $this) {
                $description->setPokemon(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
