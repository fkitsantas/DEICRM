<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 * @ORM\Table(name="dei_accounts")
 */
class Account
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
    private $OfficePhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $EmailAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingAddressStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingAddressCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingAddressState;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingAddressPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingAddressCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingAddressStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingAddressCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingAddressState;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingAddressPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingAddressCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Type;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CreatedBy;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AnnualRevenue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SICCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MemberOf;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MemberOfId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Industry;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Employees;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TickerSymbol;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Ownership;


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
    private $Rating;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedTo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedToId;


    /**
     * @ORM\Column(type="string", length=255)
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

    public function getOfficePhone(): ?string
    {
        return $this->OfficePhone;
    }

    public function setOfficePhone(?string $OfficePhone): self
    {
        $this->OfficePhone = $OfficePhone;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->EmailAddress;
    }

    public function setEmailAddress(?string $EmailAddress): self
    {
        $this->EmailAddress = $EmailAddress;

        return $this;
    }


    public function getWebsite(): ?string
    {
        return $this->Website;
    }

    public function setWebsite(?string $Website): self
    {
        $this->Website = $Website;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->Fax;
    }

    public function setFax(?string $Fax): self
    {
        $this->Fax = $Fax;

        return $this;
    }

    public function getBillingAddressStreet(): ?string
    {
        return $this->BillingAddressStreet;
    }

    public function setBillingAddressStreet(?string $BillingAddressStreet): self
    {
        $this->BillingAddressStreet = $BillingAddressStreet;

        return $this;
    }

    public function getBillingAddressCity(): ?string
    {
        return $this->BillingAddressCity;
    }

    public function setBillingAddressCity(?string $BillingAddressCity): self
    {
        $this->BillingAddressCity = $BillingAddressCity;

        return $this;
    }

    public function getBillingAddressState(): ?string
    {
        return $this->BillingAddressState;
    }

    public function setBillingAddressState(?string $BillingAddressState): self
    {
        $this->BillingAddressState = $BillingAddressState;

        return $this;
    }

    public function getBillingAddressPostalCode(): ?string
    {
        return $this->BillingAddressPostalCode;
    }

    public function setBillingAddressPostalCode(?string $BillingAddressPostalCode): self
    {
        $this->BillingAddressPostalCode = $BillingAddressPostalCode;

        return $this;
    }

    public function getBillingAddressCountry(): ?string
    {
        return $this->BillingAddressCountry;
    }

    public function setBillingAddressCountry(?string $BillingAddressCountry): self
    {
        $this->BillingAddressCountry = $BillingAddressCountry;

        return $this;
    }

    public function getShippingAddressStreet(): ?string
    {
        return $this->ShippingAddressStreet;
    }

    public function setShippingAddressStreet(?string $ShippingAddressStreet): self
    {
        $this->ShippingAddressStreet = $ShippingAddressStreet;

        return $this;
    }

    public function getShippingAddressCity(): ?string
    {
        return $this->ShippingAddressCity;
    }

    public function setShippingAddressCity(?string $ShippingAddressCity): self
    {
        $this->ShippingAddressCity = $ShippingAddressCity;

        return $this;
    }

    public function getShippingAddressState(): ?string
    {
        return $this->ShippingAddressState;
    }

    public function setShippingAddressState(?string $ShippingAddressState): self
    {
        $this->ShippingAddressState = $ShippingAddressState;

        return $this;
    }

    public function getShippingAddressPostalCode(): ?string
    {
        return $this->ShippingAddressPostalCode;
    }

    public function setShippingAddressPostalCode(?string $ShippingAddressPostalCode): self
    {
        $this->ShippingAddressPostalCode = $ShippingAddressPostalCode;

        return $this;
    }

    public function getShippingAddressCountry(): ?string
    {
        return $this->ShippingAddressCountry;
    }

    public function setShippingAddressCountry(?string $ShippingAddressCountry): self
    {
        $this->ShippingAddressCountry = $ShippingAddressCountry;

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

    public function getAnnualRevenue(): ?string
    {
        return $this->AnnualRevenue;
    }

    public function setAnnualRevenue(?string $AnnualRevenue): self
    {
        $this->AnnualRevenue = $AnnualRevenue;

        return $this;
    }

    public function getSICCode(): ?string
    {
        return $this->SICCode;
    }

    public function setSICCode(?string $SICCode): self
    {
        $this->SICCode = $SICCode;

        return $this;
    }

    public function getMemberOf(): ?string
    {
        return $this->MemberOf;
    }

    public function setMemberOf(?string $MemberOf): self
    {
        $this->MemberOf = $MemberOf;

        return $this;
    }

    public function getMemberOfId(): ?string
    {
        return $this->MemberOfId;
    }

    public function setMemberOfId(?string $MemberOfId): self
    {
        $this->MemberOfId = $MemberOfId;

        return $this;
    }


    public function getIndustry(): ?string
    {
        return $this->Industry;
    }

    public function setIndustry(?string $Industry): self
    {
        $this->Industry = $Industry;

        return $this;
    }

    public function getEmployees(): ?string
    {
        return $this->Employees;
    }

    public function setEmployees(?string $Employees): self
    {
        $this->Employees = $Employees;

        return $this;
    }

    public function getTickerSymbol(): ?string
    {
        return $this->TickerSymbol;
    }

    public function setTickerSymbol(?string $TickerSymbol): self
    {
        $this->TickerSymbol = $TickerSymbol;

        return $this;
    }

    public function getOwnership(): ?string
    {
        return $this->Ownership;
    }

    public function setOwnership(?string $Ownership): self
    {
        $this->Ownership = $Ownership;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->Rating;
    }

    public function setRating(?string $Rating): self
    {
        $this->Rating = $Rating;

        return $this;
    }


    public function getDateCreated(): ?string
    {
        return $this->DateCreated;
    }

    public function setDateCreated(string $DateCreated): self
    {
        $this->DateCreated = $DateCreated;

        return $this;
    }


    public function getCreatedBy(): ?string
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(string $CreatedBy): self
    {
        $this->CreatedBy = $CreatedBy;

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
}
