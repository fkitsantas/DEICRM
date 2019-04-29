<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InteractionRepository")
 * @ORM\Table(name="dei_interaction")
 */
class Interaction
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
    private $MediaType;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LineDurationL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LineDurationS;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Direction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RemoteAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Dnis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LastIc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Who;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $WhoBy;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Type;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $FromDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ToDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $FromTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ToTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $WhoTo;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMediaType(): ?string
    {
        return $this->MediaType;
    }

    public function setMediaType(?string $MediaType): self
    {
        $this->MediaType = $MediaType;

        return $this;
    }





    public function getLineDurationL(): ?string
    {
        return $this->LineDurationL;
    }

    public function setLineDurationL(?string $LineDurationL): self
    {
        $this->LineDurationL = $LineDurationL;

        return $this;
    }

    public function getLineDurationS(): ?string
    {
        return $this->LineDurationS;
    }

    public function setLineDurationS(?string $LineDurationS): self
    {
        $this->LineDurationS = $LineDurationS;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->Direction;
    }

    public function setDirection(?string $Direction): self
    {
        $this->Direction = $Direction;

        return $this;
    }

    public function getRemoteAddress(): ?string
    {
        return $this->RemoteAddress;
    }

    public function setRemoteAddress(?string $RemoteAddress): self
    {
        $this->RemoteAddress = $RemoteAddress;

        return $this;
    }

    public function getDnis(): ?string
    {
        return $this->Dnis;
    }

    public function setDnis(?string $Dnis): self
    {
        $this->Dnis = $Dnis;

        return $this;
    }

    public function getLastIc(): ?string
    {
        return $this->LastIc;
    }

    public function setLastIc(?string $LastIc): self
    {
        $this->LastIc = $LastIc;

        return $this;
    }

    public function getWho(): ?int
    {
        return $this->Who;
    }

    public function setWho(?int $Who): self
    {
        $this->Who = $Who;

        return $this;
    }


    public function getWhoBy(): ?string
    {
        return $this->WhoBy;
    }

    public function setWhoBy(?string $WhoBy): self
    {
        $this->WhoBy = $WhoBy;

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

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->FromDate;
    }

    public function setFromDate(?\DateTimeInterface $FromDate): self
    {
        $this->FromDate = $FromDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->ToDate;
    }

    public function setToDate(?\DateTimeInterface $ToDate): self
    {
        $this->ToDate = $ToDate;

        return $this;
    }

    public function getFromTime(): ?string
    {
        return $this->FromTime;
    }

    public function setFromTime(?string $FromTime): self
    {
        $this->FromTime = $FromTime;

        return $this;
    }

    public function getToTime(): ?string
    {
        return $this->ToTime;
    }

    public function setToTime(?string $ToTime): self
    {
        $this->ToTime = $ToTime;

        return $this;
    }

    public function getWhoTo(): ?string
    {
        return $this->WhoTo;
    }

    public function setWhoTo(?string $WhoTo): self
    {
        $this->WhoTo = $WhoTo;

        return $this;
    }
}
