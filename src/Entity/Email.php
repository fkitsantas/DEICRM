<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailRepository")
 * @ORM\Table(name="dei_emails")
 */
class Email
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Message;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SentDate;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CreatedBy;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Type;


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


    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(?string $Message = null): self
    {
        $this->Message = $Message;

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


    public function getSentDate(): ?string
    {
        return $this->SentDate;
    }

    public function setSentDate(?string $SentDate = null): self
    {
        $this->SentDate = $SentDate;

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

    public function getDateSent(): ?string
    {
        return $this->DateSent;
    }

    public function setDateSent(?string $DateSent = null): self
    {
        $this->DateSent = $DateSent;

        return $this;
    }
}
