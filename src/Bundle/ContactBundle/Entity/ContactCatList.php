<?php

namespace CRM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

//use CRM\ContactBundle\Entity\Composite;
/**
 * @ORM\Entity
 * @ORM\Table(name="ContactsCatList")
 * @ORM\HasLifecycleCallbacks()
 */
class ContactCatList {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="catlist")
     * @ORM\JoinColumn(name="category_id", nullable=true, onDelete="SET NULL", referencedColumnName="id")
     * */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="catlist")
     * @ORM\JoinColumn(name="contact_id", nullable=true, onDelete="SET NULL", referencedColumnName="id")
     * */
    protected $contact;
    protected $countcat;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getContact() {
        return $this->contact;
    }

    public function setContact($contact) {
        $this->contact = $contact;
    }

    public function __toString() {
        return (string) $this->category;
    }

}
