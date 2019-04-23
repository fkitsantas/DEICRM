<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OpportunitiesRepository")
  * @ORM\Table(name="dei_opportunities")
 */
class Opportunities
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
    private $OpportunityName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Currency;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $OpportunityAmount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SalesStage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Probability;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NextStep;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AccountName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ExpectedCloseDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LeadSource;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CreatedBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Campaign;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedTo;

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

    public function getOpportunityName(): ?string
    {
        return $this->OpportunityName;
    }

    public function setOpportunityName(?string $OpportunityName): self
    {
        $this->OpportunityName = $OpportunityName;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->Currency;
    }

    public function setCurrency(?string $Currency): self
    {
        $this->Currency = $Currency;

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


    public function getOpportunityAmount(): ?string
    {
        return $this->OpportunityAmount;
    }

    public function setOpportunityAmount(?string $OpportunityAmount): self
    {
        $this->OpportunityAmount = $OpportunityAmount;

        return $this;
    }

    public function getSalesStage(): ?string
    {
        return $this->SalesStage;
    }

    public function setSalesStage(?string $SalesStage): self
    {
        $this->SalesStage = $SalesStage;

        return $this;
    }

    public function getProbability(): ?string
    {
        return $this->Probability;
    }

    public function setProbability(?string $Probability): self
    {
        $this->Probability = $Probability;

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
    
    public function getNextStep(): ?string
    {
        return $this->NextStep;
    }

    public function setNextStep(?string $NextStep): self
    {
        $this->NextStep = $NextStep;

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

    public function getExpectedCloseDate(): ?\DateTimeInterface
    {
        return $this->ExpectedCloseDate;
    }

    public function setExpectedCloseDate(?\DateTimeInterface $ExpectedCloseDate): self
    {
        $this->ExpectedCloseDate = $ExpectedCloseDate;

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

    public function getLeadSource(): ?string
    {
        return $this->LeadSource;
    }

    public function setLeadSource(?string $LeadSource): self
    {
        $this->LeadSource = $LeadSource;

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

    public function getAssignedTo(): ?string
    {
        return $this->AssignedTo;
    }

    public function setAssignedTo(?string $AssignedTo): self
    {
        $this->AssignedTo = $AssignedTo;

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
}
