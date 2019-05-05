<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @ORM\Table(name="dei_contacts")
 */
class Contact
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
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Department;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $OfficePhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PrimaryAddressStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PrimaryAddressCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PrimaryAddressState;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PrimaryAddressPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PrimaryAddressCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AlternateAddressStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AlternateAddressCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AlternateAddressState;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AlternateAddressPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AlternateAddressCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $EmailAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ReportsTo;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ReportsToId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LeadSource;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Campaign;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CampaignID;

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

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private $CreatedBy;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title = null): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->Department;
    }

    public function setDepartment(string $Department = null): self
    {
        $this->Department = $Department;

        return $this;
    }

    public function getOfficePhone(): ?string
    {
        return $this->OfficePhone;
    }

    public function setOfficePhone(string $OfficePhone = null): self
    {
        $this->OfficePhone = $OfficePhone;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->Mobile;
    }

    public function setMobile(?string $Mobile = null): self
    {
        $this->Mobile = $Mobile;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->Fax;
    }

    public function setFax(?string $Fax= null): self
    {
        $this->Fax = $Fax;

        return $this;
    }

    public function getPrimaryAddressStreet(): ?string
    {
        return $this->PrimaryAddressStreet;
    }

    public function setPrimaryAddressStreet(?string $PrimaryAddressStreet = null): self
    {
        $this->PrimaryAddressStreet = $PrimaryAddressStreet;

        return $this;
    }

    public function getPrimaryAddressCity(): ?string
    {
        return $this->PrimaryAddressCity;
    }

    public function setPrimaryAddressCity(?string $PrimaryAddressCity = null): self
    {
        $this->PrimaryAddressCity = $PrimaryAddressCity;

        return $this;
    }

    public function getPrimaryAddressState(): ?string
    {
        return $this->PrimaryAddressState;
    }

    public function setPrimaryAddressState(?string $PrimaryAddressState = null): self
    {
        $this->PrimaryAddressState = $PrimaryAddressState;

        return $this;
    }

    public function getPrimaryAddressPostalCode(): ?string
    {
        return $this->PrimaryAddressPostalCode;
    }

    public function setPrimaryAddressPostalCode(?string $PrimaryAddressPostalCode = null): self
    {
        $this->PrimaryAddressPostalCode = $PrimaryAddressPostalCode;

        return $this;
    }

    public function getPrimaryAddressCountry(): ?string
    {
        return $this->PrimaryAddressCountry;
    }

    public function setPrimaryAddressCountry(?string $PrimaryAddressCountry = null): self
    {
        $this->PrimaryAddressCountry = $PrimaryAddressCountry;

        return $this;
    }

    public function getAlternateAddressStreet(): ?string
    {
        return $this->AlternateAddressStreet;
    }

    public function setAlternateAddressStreet(?string $AlternateAddressStreet = null): self
    {
        $this->AlternateAddressStreet = $AlternateAddressStreet;

        return $this;
    }

    public function getAlternateAddressCity(): ?string
    {
        return $this->AlternateAddressCity;
    }

    public function setAlternateAddressCity(?string $AlternateAddressCity = null): self
    {
        $this->AlternateAddressCity = $AlternateAddressCity;

        return $this;
    }

    public function getAlternateAddressState(): ?string
    {
        return $this->AlternateAddressState;
    }

    public function setAlternateAddressState(?string $AlternateAddressState = null): self
    {
        $this->AlternateAddressState = $AlternateAddressState;

        return $this;
    }

    public function getAlternateAddressPostalCode(): ?string
    {
        return $this->AlternateAddressPostalCode;
    }

    public function setAlternateAddressPostalCode(?string $AlternateAddressPostalCode = null): self
    {
        $this->AlternateAddressPostalCode = $AlternateAddressPostalCode;

        return $this;
    }

    public function getAlternateAddressCountry(): ?string
    {
        return $this->AlternateAddressCountry;
    }

    public function setAlternateAddressCountry(?string $AlternateAddressCountry = null): self
    {
        $this->AlternateAddressCountry = $AlternateAddressCountry;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->EmailAddress;
    }

    public function setEmailAddress(?string $EmailAddress = null): self
    {
        $this->EmailAddress = $EmailAddress;

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


    public function getLeadSource(): ?string
    {
        return $this->LeadSource;
    }

    public function setLeadSource(?string $LeadSource = null): self
    {
        $this->LeadSource = $LeadSource;

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

    public function getCreatedBy(): ?string
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?string $CreatedBy = null): self
    {
        $this->CreatedBy = $CreatedBy;

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




    public function getReportsTo(): ?string
    {
        return $this->ReportsTo;
    }

    public function setReportsTo(?string $ReportsTo): self
    {
        $this->ReportsTo = $ReportsTo;

        return $this;
    }

    public function getReportsToId(): ?string
    {
        return $this->ReportsToId;
    }

    public function setReportsToId(?string $ReportsToId): self
    {
        $this->ReportsToId = $ReportsToId;

        return $this;
    }
}
