<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DisputeRepository")
 * @ORM\Table(name="dei_dispute")
 */
class Dispute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Priority;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Subject;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AccountName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Resolution;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedTo;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedToId;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DateCreated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DateModified;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->Number;
    }

    public function setNumber(?int $Number): self
    {
        $this->Number = $Number;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->Priority;
    }

    public function setPriority(?string $Priority): self
    {
        $this->Priority = $Priority;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(?string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->Subject;
    }

    public function setSubject(?string $Subject): self
    {
        $this->Subject = $Subject;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->AccountName;
    }

    public function setAccountName(?string $AccountName): self
    {
        $this->AccountName = $AccountName;

        return $this;
    }

    public function getResolution(): ?string
    {
        return $this->Resolution;
    }

    public function setResolution(?string $Resolution): self
    {
        $this->Resolution = $Resolution;

        return $this;
    }



    public function getDateCreated(): ?string
    {
        return $this->DateCreated;
    }

    public function setDateCreated(?string $DateCreated): self
    {
        $this->DateCreated = $DateCreated;

        return $this;
    }

    public function getDateModified(): ?string
    {
        return $this->DateModified;
    }

    public function setDateModified(?string $DateModified): self
    {
        $this->DateModified = $DateModified;

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

    public function getAssignedToId(): ?string
    {
        return $this->AssignedToId;
    }

    public function setAssignedToId(?string $AssignedToId): self
    {
        $this->AssignedToId = $AssignedToId;

        return $this;
    }
}
