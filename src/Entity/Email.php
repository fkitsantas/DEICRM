<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailRepository")
 */
class Email
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedTo;

    /**
     * @ORM\Column(type="integer")
     */
    private $AssignedToId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getAssignedTo(): ?string
    {
        return $this->AssignedTo;
    }

    public function setAssignedTo(?string $AssignedTo): self
    {
        $this->AssignedTo = $AssignedTo;

        return $this;
    }

    public function getAssignedToId(): ?int
    {
        return $this->AssignedToId;
    }

    public function setAssignedToId(int $AssignedToId): self
    {
        $this->AssignedToId = $AssignedToId;

        return $this;
    }
}
