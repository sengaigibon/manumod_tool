<?php

namespace App\Entity;

use App\Repository\AuditLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "AuditLog")]
#[ORM\Entity(repositoryClass: AuditLogRepository::class)]
class AuditLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: "entityType", length: 255)]
    private ?string $entityType = null;

    #[ORM\Column(name: "entityId")]
    private ?int $entityId = null;

    #[ORM\Column(name: "createdAt")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'id')]
    #[ORM\JoinColumn(name: 'userId', referencedColumnName: 'id')]
//    #[ORM\ManyToOne]
    private ?User $user = null;

    #[ORM\Column(name: "action", length: 255)]
    private ?string $action = null;

    #[ORM\Column(name: "eventData")]
    private array $eventData = [];

    #[ORM\Column(name: "ipAddress", length: 255)]
    private ?string $ipAddress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityType(): ?string
    {
        return $this->entityType;
    }

    public function setEntityType(string $entityType): AuditLog
    {
        $this->entityType = $entityType;
        return $this;
    }

    public function getEntityId(): ?int
    {
        return $this->entityId;
    }

    public function setEntityId(?int $entityId): AuditLog
    {
        $this->entityId = $entityId;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): AuditLog
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): AuditLog
    {
        $this->user = $user;
        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): AuditLog
    {
        $this->action = $action;
        return $this;
    }

    public function getEventData(): string
    {
        return json_encode($this->eventData);
    }

    public function setEventData(array $eventData): AuditLog
    {
        $this->eventData = $eventData;
        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): AuditLog
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

}
