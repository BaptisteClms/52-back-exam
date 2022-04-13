<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(normalizationContext={
            "groups"="user_read"
 *     })
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("user_read")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups("user_read")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups("user_read")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user_read")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user_read")
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer")
     * @Groups("user_read")
     */
    private $coins;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="ludi")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Ludi::class, mappedBy="users")
     * @Groups("user_read")
     * @ApiSubresource()
     */
    private $ludis;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->ludis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCoins(): ?int
    {
        return $this->coins;
    }

    public function setCoins(int $coins): self
    {
        $this->coins = $coins;

        return $this;
    }

    public function getLudi(): ?self
    {
        return $this->ludi;
    }

    public function setLudi(?self $ludi): self
    {
        $this->ludi = $ludi;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setLudi($this);
        }

        return $this;
    }

    public function removeUser(self $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLudi() === $this) {
                $user->setLudi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ludi>
     */
    public function getLudis(): Collection
    {
        return $this->ludis;
    }

    public function addLudi(Ludi $ludi): self
    {
        if (!$this->ludis->contains($ludi)) {
            $this->ludis[] = $ludi;
            $ludi->setUsers($this);
        }

        return $this;
    }

    public function removeLudi(Ludi $ludi): self
    {
        if ($this->ludis->removeElement($ludi)) {
            // set the owning side to null (unless already changed)
            if ($ludi->getUsers() === $this) {
                $ludi->setUsers(null);
            }
        }

        return $this;
    }
}
