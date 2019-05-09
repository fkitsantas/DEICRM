<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CasesCommentRepository")
 * @ORM\Table(name="dei_cases_comments")
 */
class CasesComment
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
    private $Message;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Type;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AddedBy;



    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CaseId;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AddedById;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AccountId;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Date;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AccountName;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(?string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }



    public function getCaseId(): ?int
    {
        return $this->CaseId;
    }

    public function setCaseId(?int $CaseId): self
    {
        $this->CaseId = $CaseId;

        return $this;
    }


    public function getAddedById(): ?int
    {
        return $this->AddedById;
    }

    public function setAddedById(?int $AddedById): self
    {
        $this->AddedById = $AddedById;

        return $this;
    }

    public function getAccountId(): ?int
    {
        return $this->AccountId;
    }

    public function setAccountId(?int $AccountId): self
    {
        $this->AccountId = $AccountId;

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



    public function getAddedBy(): ?string
    {
        return $this->AddedBy;
    }

    public function setAddedBy(?string $AddedBy): self
    {
        $this->AddedBy = $AddedBy;

        return $this;
    }





    public function getDate(): ?string
    {
        return $this->Date;
    }

    public function setDate(?string $Date): self
    {
        $this->Date = $Date;

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
}
