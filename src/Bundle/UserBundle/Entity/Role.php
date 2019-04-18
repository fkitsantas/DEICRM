<?php

/*
 * This software belongs to Rhea Software S.R.O. 
 * Any other information are specified in the software contract agreement. 
 */

namespace CRM\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Roles")
 */
class Role implements RoleInterface {

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
     * @ORM\Column(name="role", type="string", length=20, unique=true)
     */
    protected $role;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="UserRole" , mappedBy="role" , cascade={"all"})
     * */
    protected $rolelist;


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @see RoleInterface
     */
    public function getRole()
    {
        return $this->role;
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

    public function getRoleList() {
        return $this->rolelist;
    }

    public function setRoleList($rolelist) {
        $this->rolelist = $rolelist;
    }

    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

}