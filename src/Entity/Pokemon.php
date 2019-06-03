<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\TypeEnum;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PokemonRepository")
 * @UniqueEntity(
 *  fields="no_pokedex",
 *  message="Ce numero pokedex existe déjà." 
 * )
 * @UniqueEntity(
 *  fields="name",
 *  message="Ce pokemon existe déjà." 
 * )
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
     * @ORM\Column(type="integer", unique=true)
     * @Assert\Type("integer")
     */
    private $no_pokedex;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     */
    private $hp;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     */
    private $atk;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     */
    private $def;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     */
    private $spe;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     */
    private $speed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Choice(callback = {"App\Enum\TypeEnum", "getAvailableTypes"})
     */
    private $type1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Choice(callback = {"App\Enum\TypeEnum", "getAvailableTypes"})
     */
    private $type2;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1)
     */
    private $size;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1)
     */
    private $weight;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttackSlot", mappedBy="pokemon", cascade={"persist", "remove"})
     */
    private $attackSlots;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     */
    private $nature;

    /**
     * @ORM\Column(type="string", length=510)
     * @Assert\Type("string")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $editedAt;

    public function __construct()
    {
        $this->attackSlots = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * @param mixed $nature
     * @return Pokemon
     */
    public function setNature($nature)
    {
        $this->nature = $nature;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Pokemon
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
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
        if (!in_array($type1, TypeEnum::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid type");
        }
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): self
    {
        if (!in_array($type2, TypeEnum::getAvailableTypes())) {
            throw new \InvalidArgumentException("Invalid type");
        }
        
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\Datetime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): self
    {
        $this->createdAt = new \Datetime;
        return $this;
    }

    public function getEditedAt(): ?\Datetime
    {
        return $this->editedAt;
    }

    public function setEditedAt(): self
    {
        $this->editedAt = new \Datetime;
        return $this;
    }
}

