<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttackRepository")
 */
class Attack
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_cs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $accuracy;

    /**
     * @ORM\Column(type="integer")
     */
    private $power;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $ct;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttackSlot", mappedBy="attack")
     */
    private $attackSlots;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="`key`", type="string", length=255)
     */
    private $key;

    public function __construct()
    {
        $this->attackSlots = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAccuracy(): ?int
    {
        return $this->accuracy;
    }

    /**
     * @param mixed $accuracy
     */
    public function setAccuracy($accuracy): self
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPower(): ?int
    {
        return $this->power;
    }

    /**
     * @param mixed $power
     */
    public function setPower($power): self
    {
        $this->power = $power;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCt(): ?string
    {
        return $this->ct;
    }

    /**
     * @param mixed $ct
     */
    public function setCt($ct): self
    {
        $this->ct = $ct;

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

    public function getIsCs(): ?bool
    {
        return $this->is_cs;
    }

    public function setIsCs(bool $is_cs): self
    {
        $this->is_cs = $is_cs;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $attackSlot->setAttack($this);
        }

        return $this;
    }

    public function removeAttackSlot(AttackSlot $attackSlot): self
    {
        if ($this->attackSlots->contains($attackSlot)) {
            $this->attackSlots->removeElement($attackSlot);
            // set the owning side to null (unless already changed)
            if ($attackSlot->getAttack() === $this) {
                $attackSlot->setAttack(null);
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

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }
}
