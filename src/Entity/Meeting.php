<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MeetingRepository")
 * @ORM\Table(name="dei_meetings")
 */
class Meeting
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
    private $Location;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Campaign;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CampaignId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ContactName;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ContactId;


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
    private $RelatedToType;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedTo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AssignedToId;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $RelatedToId;


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

    public function setSubject(?string $Subject = null): self
    {
        $this->Subject = $Subject;

        return $this;
    }


    public function getContactName(): ?string
    {
        return $this->ContactName;
    }

    public function setContactName(?string $ContactName = null): self
    {
        $this->ContactName = $ContactName;

        return $this;
    }


    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->StartDate;
    }

    public function setStartDate(?\DateTimeInterface $StartDate = null): self
    {
        $this->StartDate = $StartDate;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->DueDate;
    }

    public function setDueDate(?\DateTimeInterface $DueDate = null): self
    {
        $this->DueDate = $DueDate;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->Location;
    }

    public function setLocation(?string $Location = null): self
    {
        $this->Location = $Location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(?string $Status = null): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getContactId(): ?int
    {
        return $this->ContactId;
    }

    public function setContactId(?int $ContactId = null): self
    {
        $this->ContactId = $ContactId;

        return $this;
    }

    public function getRelatedTo(): ?string
    {
        return $this->RelatedTo;
    }

    public function setRelatedTo(?string $RelatedTo = null): self
    {
        $this->RelatedTo = $RelatedTo;

        return $this;
    }


    public function getCampaign(): ?string
    {
        return $this->Campaign;
    }

    public function setCampaign(?string $Campaign): self
    {
        $this->Campaign = $Campaign;

        return $this;
    }


    public function getCampaignId(): ?string
    {
        return $this->CampaignId;
    }

    public function setCampaignId(?string $CampaignId): self
    {
        $this->CampaignId = $CampaignId;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description = null): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getAssignedTo(): ?string
    {
        return $this->AssignedTo;
    }

    public function setAssignedTo(?string $AssignedTo = null): self
    {
        $this->AssignedTo = $AssignedTo;

        return $this;
    }


    public function getRelatedToType(): ?string
    {
        return $this->RelatedToType;
    }

    public function setRelatedToType(?string $RelatedToType = null): self
    {
        $this->RelatedToType = $RelatedToType;

        return $this;
    }


    public function getAssignedToId(): ?int
    {
        return $this->AssignedToId;
    }

    public function setAssignedToId(?int $AssignedToId = null): self
    {
        $this->AssignedToId = $AssignedToId;

        return $this;
    }

    public function getRelatedToId(): ?int
    {
        return $this->RelatedToId;
    }

    public function setRelatedToId(?int $RelatedToId = null): self
    {
        $this->RelatedToId = $RelatedToId;

        return $this;
    }


    public function getCreatedBy(): ?string
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?string $CreatedBy = null): self
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }

    public function getDateCreated(): ?string
    {
        return $this->DateCreated;
    }

    public function setDateCreated(?string $DateCreated = null): self
    {
        $this->DateCreated = $DateCreated;

        return $this;
    }

    public function getDateModified(): ?string
    {
        return $this->DateModified;
    }

    public function setDateModified(?string $DateModified = null): self
    {
        $this->DateModified = $DateModified;

        return $this;
    }
}
