<?php

/*
 * This software belongs to Rhea Software S.R.O. 
 * Any other information are specified in the software contract agreement. 
 */

namespace CRM\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="UserActivities")
 */
class UserActivity {

    /**
     * @var integer
     *
     * @ORM\Column(name="activity_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     */
    protected $dateAdded;

    /**
     * @ORM\Column(name="creation_user", type="string", length=50)
     */
    protected $activityUser;

    /**
     * @ORM\Column(type="string", name="activity_desc", length=250)
     */
    protected $activityDesc;
    // Getters and Setters
    /**
     * @ORM\Column(type="string", name="module", length=50)
     */
    protected $module;

    public function __toString() {
        return $this->actiivty;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }

    public function getActivityDesc() {
        return $this->activityDesc;
    }

    public function setActivityDesc($activityDesc) {
        $this->activityDesc = $activityDesc;
    }

    public function setActivityUser($activityUser) {
        $this->activityUser = $activityUser;
    }

    public function getActivityUser() {
        return $this->activityUser;
    }

    public function setModule($module) {
        $this->module = $module;
    }

    public function getModule() {
        return $this->module;
    }

}
