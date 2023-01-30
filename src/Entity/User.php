<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: "User")]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, \Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 190, unique: true)]
    private string $email;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $token = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?string $lastLogin = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getRoles()
    {
        return [
            'ROLE_USER'
        ];
    }

    public function getLastLogin(): string
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?string $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->name,
            $this->email,
            $this->token
        ]);
    }

    public function unserialize($serialized)
    {
        list($this->id,
            $this->name,
            $this->email,
            $this->token) = unserialize($serialized);
    }


    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
        return '';
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
