<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GladRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GladRepository::class)
 * @ApiResource()
 */
class Glad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("glad_read")
     */
    private $name_glad;

    /**
     * @ORM\Column(type="float")
     * @Groups("glad_read")
     */
    private $address;

    /**
     * @ORM\Column(type="float")
     * @Groups("glad_read")
     */
    private $strength;

    /**
     * @ORM\Column(type="float")
     * @Groups("glad_read")
     */
    private $balance;

    /**
     * @ORM\Column(type="float")
     * @Groups("glad_read")
     */
    private $speed;

    /**
     * @ORM\Column(type="float")
     * @Groups("glad_read")
     */
    private $strat;

    /**
     * @ORM\ManyToOne(targetEntity=Ludi::class, inversedBy="gladiators")
     */
    private $ludi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameGlad(): ?string
    {
        return $this->name_glad;
    }

    public function setNameGlad(string $name_glad): self
    {
        $this->name_glad = $name_glad;

        return $this;
    }

    public function getAddress(): ?float
    {
        return $this->address;
    }

    public function setAddress(float $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getStrength(): ?float
    {
        return $this->strength;
    }

    public function setStrength(float $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getSpeed(): ?float
    {
        return $this->speed;
    }

    public function setSpeed(float $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getStrat(): ?float
    {
        return $this->strat;
    }

    public function setStrat(float $strat): self
    {
        $this->strat = $strat;

        return $this;
    }

    public function getLudi(): ?Ludi
    {
        return $this->ludi;
    }

    public function setLudi(?Ludi $ludi): self
    {
        $this->ludi = $ludi;

        return $this;
    }

    /**
     * @Groups("glad_read")
     */
    public function getValeurChar()
    {
        $randomFloat = rand(0, 10) / 10;
        $perfChar = 0.8 * $this->getAddress() + $this->getBalance() + 0.3 * $this->getStrength() + 0.1 * $this->getSpeed() + $randomFloat;
        return $perfChar;
    }

    /**
     * @Groups("glad_read")
     */
    public function getValeurLutte()
    {
        $randomFloat = rand(0, 10) / 10;
        $perfLutte = 0.3 * $this->getAddress() + 0.1 * $this->getBalance() + 0.8 * $this->getStrength() + 0.4 * $this->getSpeed() + $randomFloat;
        return $perfLutte;
    }

    /**
     * @Groups("glad_read")
     */
    public function getValeurAthletique()
    {
        $randomFloat = rand(0, 10) / 10;
        $perfAthletisme = 0.4 * $this->getAddress() + 0.4 * $this->getBalance() + 0.4 * $this->getStrength() + 0.4 * $this->getSpeed() + $randomFloat;
        return $perfAthletisme;
    }
}
