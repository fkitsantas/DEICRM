<?php

namespace CRM\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="UsersRoles")
 */
class UserRole {

      /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="rolelist")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * */
    protected $role;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="rolelist")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * */
    protected $user;
    protected $countcat;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    public function getRole() {
        return $this->role;
    }

    public function __toString() {
        return (string) $this->role;
    }

}
