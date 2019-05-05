<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 * @ORM\Table(name="dei_documents")
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload  a PDF file.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $FileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DocumentName;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $PublishDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ExpirationDate;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Status;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SubCategory;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Revision;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DocumentType;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AssignedTo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AssignedToId;


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

    public function getFileName(): ?string
    {
        return $this->FileName;
    }

    public function setFileName(?string $FileName = null): self
    {
        $this->FileName = $FileName;

        return $this;
    }


    public function getDocumentName(): ?string
    {
        return $this->DocumentName;
    }

    public function setDocumentName(?string $DocumentName = null): self
    {
        $this->DocumentName = $DocumentName;

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


    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->PublishDate;
    }

    public function setPublishDate(?\DateTimeInterface $PublishDate = null): self
    {
        $this->PublishDate = $PublishDate;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->ExpirationDate;
    }

    public function setExpirationDate(?\DateTimeInterface $ExpirationDate = null): self
    {
        $this->ExpirationDate = $ExpirationDate;

        return $this;
    }


    public function getRevision(): ?int
    {
        return $this->Revision;
    }

    public function setRevision(?int $Revision = null): self
    {
        $this->Revision = $Revision;

        return $this;
    }

    public function getDocumentType(): ?string
    {
        return $this->DocumentType;
    }

    public function setDocumentType(?string $DocumentType = null): self
    {
        $this->DocumentType = $DocumentType;

        return $this;
    }


    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(?string $Category): self
    {
        $this->Category = $Category;

        return $this;
    }


    public function getSubCategory(): ?string
    {
        return $this->SubCategory;
    }

    public function setSubCategory(?string $SubCategory): self
    {
        $this->SubCategory = $SubCategory;

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


    public function getAssignedToId(): ?int
    {
        return $this->AssignedToId;
    }

    public function setAssignedToId(?int $AssignedToId = null): self
    {
        $this->AssignedToId = $AssignedToId;

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
