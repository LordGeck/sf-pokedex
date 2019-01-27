<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttackRepository")
 */
class Attack
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
}
