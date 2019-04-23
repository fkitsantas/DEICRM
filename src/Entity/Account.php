<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
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
    private $Fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingState;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BillingCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingState;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ShippingCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Type;

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
    private $Rating;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedTo;


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

    public function getBillingStreet(): ?string
    {
        return $this->BillingStreet;
    }

    public function setBillingStreet(?string $BillingStreet): self
    {
        $this->BillingStreet = $BillingStreet;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->BillingCity;
    }

    public function setBillingCity(?string $BillingCity): self
    {
        $this->BillingCity = $BillingCity;

        return $this;
    }

    public function getBillingState(): ?string
    {
        return $this->BillingState;
    }

    public function setBillingState(?string $BillingState): self
    {
        $this->BillingState = $BillingState;

        return $this;
    }

    public function getBillingPostalCode(): ?string
    {
        return $this->BillingPostalCode;
    }

    public function setBillingPostalCode(?string $BillingPostalCode): self
    {
        $this->BillingPostalCode = $BillingPostalCode;

        return $this;
    }

    public function getBillingCountry(): ?string
    {
        return $this->BillingCountry;
    }

    public function setBillingCountry(?string $BillingCountry): self
    {
        $this->BillingCountry = $BillingCountry;

        return $this;
    }

    public function getShippingStreet(): ?string
    {
        return $this->ShippingStreet;
    }

    public function setShippingStreet(?string $ShippingStreet): self
    {
        $this->ShippingStreet = $ShippingStreet;

        return $this;
    }

    public function getShippingCity(): ?string
    {
        return $this->ShippingCity;
    }

    public function setShippingCity(?string $ShippingCity): self
    {
        $this->ShippingCity = $ShippingCity;

        return $this;
    }

    public function getShippingState(): ?string
    {
        return $this->ShippingState;
    }

    public function setShippingState(?string $ShippingState): self
    {
        $this->ShippingState = $ShippingState;

        return $this;
    }

    public function getShippingPostalCode(): ?string
    {
        return $this->ShippingPostalCode;
    }

    public function setShippingPostalCode(?string $ShippingPostalCode): self
    {
        $this->ShippingPostalCode = $ShippingPostalCode;

        return $this;
    }

    public function getShippingCountry(): ?string
    {
        return $this->ShippingCountry;
    }

    public function setShippingCountry(?string $ShippingCountry): self
    {
        $this->ShippingCountry = $ShippingCountry;

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

    public function setDateCreated(string $DateCreated): self
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
