<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampaignsRepository")
 * @ORM\Table(name="dei_campaigns")
 */
class Campaigns
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
    private $Status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $StartDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $EndDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Currency;

    /**
     * @ORM\Column(type="integer")
     */
    private $Impressions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Budget;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ExpectedCost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ActualCost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Objective;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Type;


    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private $CreatedBy;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ExpectedRevenue;

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

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->StartDate;
    }

    public function setStartDate(?\DateTimeInterface $StartDate): self
    {
        $this->StartDate = $StartDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->EndDate;
    }

    public function setEndDate(?\DateTimeInterface $EndDate): self
    {
        $this->EndDate = $EndDate;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->Currency;
    }

    public function setCurrency(?string $Currency = null): self
    {
        $this->Currency = $Currency;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type = null): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getImpressions(): ?int
    {
        return $this->Impressions;
    }

    public function setImpressions(int $Impressions = null): self
    {
        $this->Impressions = $Impressions;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->Budget;
    }

    public function setBudget(?string $Budget = null): self
    {
        $this->Budget = $Budget;

        return $this;
    }

    public function getExpectedCost(): ?string
    {
        return $this->ExpectedCost;
    }

    public function setExpectedCost(?string $ExpectedCost = null): self
    {
        $this->ExpectedCost = $ExpectedCost;

        return $this;
    }

    public function getActualCost(): ?string
    {
        return $this->ActualCost;
    }

    public function setActualCost(?string $ActualCost = null): self
    {
        $this->ActualCost = $ActualCost;

        return $this;
    }

    public function getObjective(): ?string
    {
        return $this->Objective;
    }

    public function setObjective(?string $Objective = null): self
    {
        $this->Objective = $Objective;

        return $this;
    }

    public function getExpectedRevenue(): ?string
    {
        return $this->ExpectedRevenue;
    }

    public function setExpectedRevenue(?string $ExpectedRevenue = null): self
    {
        $this->ExpectedRevenue = $ExpectedRevenue;

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

    public function getDateModified(): ?string
    {
        return $this->DateModified;
    }

    public function setDateModified(?string $DateModified = null): self
    {
        $this->DateModified = $DateModified;

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


    public function getCreatedBy(): ?string
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?string $CreatedBy = null): self
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }
}
