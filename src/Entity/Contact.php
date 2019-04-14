<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @ORM\Table(name="dei_contact")
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
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $office;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $primary_address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lead_source;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $campaign;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reports_to;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intials;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $assigned_to;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alternative_address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alternative_city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alternative_state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alternative_postal_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alternative_country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fax;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getOffice(): ?string
    {
        return $this->office;
    }

    public function setOffice(?string $office): self
    {
        $this->office = $office;

        return $this;
    }

    public function getPrimaryAddress(): ?string
    {
        return $this->primary_address;
    }

    public function setPrimaryAddress(?string $primary_address): self
    {
        $this->primary_address = $primary_address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(?string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLeadSource(): ?string
    {
        return $this->lead_source;
    }

    public function setLeadSource(?string $lead_source): self
    {
        $this->lead_source = $lead_source;

        return $this;
    }

    public function getCampaign(): ?string
    {
        return $this->campaign;
    }

    public function setCampaign(?string $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getReportsTo(): ?string
    {
        return $this->reports_to;
    }

    public function setReportsTo(?string $reports_to): self
    {
        $this->reports_to = $reports_to;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getIntials(): ?string
    {
        return $this->intials;
    }

    public function setIntials(string $intials): self
    {
        $this->intials = $intials;

        return $this;
    }

    public function getAssignedTo(): ?string
    {
        return $this->assigned_to;
    }

    public function setAssignedTo(?string $assigned_to): self
    {
        $this->assigned_to = $assigned_to;

        return $this;
    }

    public function getAlternativeAddress(): ?string
    {
        return $this->alternative_address;
    }

    public function setAlternativeAddress(?string $alternative_address): self
    {
        $this->alternative_address = $alternative_address;

        return $this;
    }

    public function getAlternativeCity(): ?string
    {
        return $this->alternative_city;
    }

    public function setAlternativeCity(?string $alternative_city): self
    {
        $this->alternative_city = $alternative_city;

        return $this;
    }

    public function getAlternativeState(): ?string
    {
        return $this->alternative_state;
    }

    public function setAlternativeState(?string $alternative_state): self
    {
        $this->alternative_state = $alternative_state;

        return $this;
    }

    public function getAlternativePostalCode(): ?string
    {
        return $this->alternative_postal_code;
    }

    public function setAlternativePostalCode(?string $alternative_postal_code): self
    {
        $this->alternative_postal_code = $alternative_postal_code;

        return $this;
    }

    public function getAlternativeCountry(): ?string
    {
        return $this->alternative_country;
    }

    public function setAlternativeCountry(?string $alternative_country): self
    {
        $this->alternative_country = $alternative_country;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }
}
