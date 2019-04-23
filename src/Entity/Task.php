<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
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
    private $Subject;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $StartDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DueDate;

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
    private $RelatedTo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ContactName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedTo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CreatedBy;

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

    public function getSubject(): ?string
    {
        return $this->Subject;
    }

    public function setSubject(?string $Subject): self
    {
        $this->Subject = $Subject;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->StartDate;
    }

    public function setStartDate(?\DateTimeInterface $StartDate): self
    {
        $this->StartDate = $StartDate;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->DueDate;
    }

    public function setDueDate(?\DateTimeInterface $DueDate): self
    {
        $this->DueDate = $DueDate;

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

    public function getRelatedTo(): ?string
    {
        return $this->RelatedTo;
    }

    public function setRelatedTo(?string $RelatedTo): self
    {
        $this->RelatedTo = $RelatedTo;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->ContactName;
    }

    public function setContactName(?string $ContactName): self
    {
        $this->ContactName = $ContactName;

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

    public function getAssignedTo(): ?string
    {
        return $this->AssignedTo;
    }

    public function setAssignedTo(?string $AssignedTo): self
    {
        $this->AssignedTo = $AssignedTo;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?string $CreatedBy): self
    {
        $this->CreatedBy = $CreatedBy;

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
}
