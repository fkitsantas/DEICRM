<?php

namespace CRM\ContactBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ContactsCategory")
 */
class Category {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @var string $name
     * 
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="ContactCatList" , mappedBy="category" , cascade={"all"})
     * */
    protected $catlist;

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     */
    protected $creationDate;

    /**
     * @ORM\Column(name="creation_user", type="string", length=50)
     */
    protected $creationUser;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCatList() {
        return $this->catlist;
    }

    public function setCatList($catlist) {
        $this->catlist = $catlist;
    }

    public function __toString() {
        return $this->name;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationUser($creationUser)
    {
        $this->creationUser = $creationUser;

        return $this;
    }

    public function getCreationUser()
    {
        return $this->creationUser;
    }
}
