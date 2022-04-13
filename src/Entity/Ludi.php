<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LudiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LudiRepository::class)
 * @ApiResource()
 */
class Ludi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_ludi;

    /**
     * @ORM\Column(type="boolean")
     */
    private $courseDeChar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $lutte;

    /**
     * @ORM\Column(type="boolean")
     */
    private $athletisme;

    /**
     * @ORM\OneToMany(targetEntity=Glad::class, mappedBy="ludi")
     */
    private $gladiators;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ludis")
     */
    private $users;

    public function __construct()
    {
        $this->gladiators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameLudi(): ?string
    {
        return $this->name_ludi;
    }

    public function setNameLudi(string $name_ludi): self
    {
        $this->name_ludi = $name_ludi;

        return $this;
    }

    public function getCourseDeChar(): ?bool
    {
        return $this->courseDeChar;
    }

    public function setCourseDeChar(bool $courseDeChar): self
    {
        $this->courseDeChar = $courseDeChar;

        return $this;
    }

    public function getLutte(): ?bool
    {
        return $this->lutte;
    }

    public function setLutte(bool $lutte): self
    {
        $this->lutte = $lutte;

        return $this;
    }

    public function getAthletisme(): ?bool
    {
        return $this->athletisme;
    }

    public function setAthletisme(bool $athletisme): self
    {
        $this->athletisme = $athletisme;

        return $this;
    }

    /**
     * @return Collection<int, glad>
     */
    public function getGladiators(): Collection
    {
        return $this->gladiators;
    }

    public function addGladiator(glad $gladiator): self
    {
        if (!$this->gladiators->contains($gladiator)) {
            $this->gladiators[] = $gladiator;
            $gladiator->setLudi($this);
        }

        return $this;
    }

    public function removeGladiator(glad $gladiator): self
    {
        if ($this->gladiators->removeElement($gladiator)) {
            // set the owning side to null (unless already changed)
            if ($gladiator->getLudi() === $this) {
                $gladiator->setLudi(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?user
    {
        return $this->users;
    }

    public function setUsers(?user $users): self
    {
        $this->users = $users;

        return $this;
    }
}
