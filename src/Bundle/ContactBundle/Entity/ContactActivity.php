<?php

/*
 * This software belongs to Rhea Software S.R.O. 
 * Any other information are specified in the software contract agreement. 
 */

namespace CRM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ContactActivities")
 */
class ContactActivity {

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
     * @ORM\Column(name="creation_user", type="string", length=250)
     */
    protected $activityUser;

    /**
     * @ORM\Column(type="string", name="activity_desc", length=250)
     */
    protected $activityDesc;

    /**
     * @ORM\Column(type="string", name="contact_module", length=20)
     */
    protected $contactModule;

    /**
     * @ORM\Column(type="string", name="contact_account_id", length=20)
     */
    protected $contactAccountId;

    // Getters and Setters

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

    public function setContactModule($contactModule) {
        $this->contactModule = $contactModule;
    }

    public function getContactModule() {
        return $this->contactModule;
    }

    public function setContactAccountId($contactAccountId) {
        $this->contactAccountId = $contactAccountId;
    }

    public function getContactAccountId() {
        return $this->contactAccountId;
    }

}
