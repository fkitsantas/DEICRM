<?php

/*
 * This application belongs to Rhea Software (rheasoftware.com)
 * Illegal distribution is prohibited and punishable by law.  * 
 */

namespace CRM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Accounts")
 */
class Account {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="accounttitle", type="string", length=50)
     */
    protected $name;

    /**
     * @ORM\Column(name="accounttype", type="string", length=50)
     */
    protected $accounttype;

    /**
     * @ORM\Column(name="manager", type="string", length=50)
     */
    protected $manager;

    /**
     * @ORM\Column(name="shortdesc", type="string", length=250)
     */
    protected $shortdesc;

    /**
     * @ORM\Column(name="primaryname", type="string", length=50)
     */
    protected $primaryname;

    /**
     * @ORM\Column(name="primaryemail", type="string", length=50)
     */
    protected $primaryemail;

    /**
     * @ORM\Column(name="primaryphone", type="string", length=50)
     */
    protected $primaryphone; 

    /**
     * @ORM\Column(name="addstreet", type="string", length=50, nullable=true)
     */
    protected $addstreet;

    /**
     * @ORM\Column(name="addstate", type="string", length=50, nullable=true)
     */
    protected $addstate;

    /**
     * @ORM\Column(name="addcity", type="string", length=50, nullable=true)
     */
    protected $addcity;

    /**
     * @ORM\Column(name="addcountry", type="string", length=50, nullable=true)
     */
    protected $addcountry;

    /**
     * @ORM\Column(type="string", name="addphone1", length=50, nullable=true)
     */
    protected $addphone1;

    /**
     * @ORM\Column(type="string", name="addmobile", length=50, nullable=true)
     */
    protected $addmobile;

    /**
     * @ORM\Column(type="string", name="addfax", length=50, nullable=true)
     */
    protected $addfax;

    /**
     * @ORM\Column(type="string", name="addemail", length=50, nullable=true)
     */
    protected $addemail;

    /**
     * @ORM\Column(type="string", name="addwebsite", length=50, nullable=true)
     */
    protected $addwebsite;

    /**
     * @var string
     *
     * @ORM\Column(name="linkedin", type="string", length=20, nullable=true)
     */
    protected $linkedin;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=20, nullable=true)
     */
    protected $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=20, nullable=true)
     */
    protected $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="skype", type="string", length=20, nullable=true)
     */
    protected $skype;

    /**
     * @var string
     *
     * @ORM\Column(name="googleid", type="string", length=20, nullable=true)
     */
    protected $googleid;

    /**
     * @ORM\Column(type="string", name="addnotes", length=1000, nullable=true)
     */
    protected $addnotes;

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     */
    protected $dateAdded;

    //Account Entity's Getters and Setters

    /**
     * @ORM\Column(type="string", name="creation_user", length=150)
     */
    protected $creation_user;

    public function __toString() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setAccountType($accounttype) {
        $this->accounttype = $accounttype;
    }

    public function getAccountType() {
        return $this->accounttype;
    }

    public function setManager($manager) {
        $this->manager = $manager;
    }

    public function getManager() {
        return $this->manager;
    }

    public function setShortdesc($shortdesc) {
        $this->shortdesc = $shortdesc;
    }

    public function getShortdesc() {
        return $this->shortdesc;
    }

    public function setPrimaryname($primaryname) {
        $this->primaryname = $primaryname;
    }

    public function getPrimaryname() {
        return $this->primaryname;
    }

    public function setPrimaryemail($primaryemail) {
        $this->primaryemail = $primaryemail;
    }

    public function getPrimaryemail() {
        return $this->primaryemail;
    }

    public function setPrimaryphone($primaryphone) {
        $this->primaryphone = $primaryphone;
    }

    public function getPrimaryphone() {
        return $this->primaryphone;
    }
  
    public function setAddstreet($addstreet) {
        $this->addstreet = $addstreet;
    }

    public function getAddstreet() {
        return $this->addstreet;
    }

    public function setAddstate($addstate) {
        $this->addstate = $addstate;
    }

    public function getAddstate() {
        return $this->addstate;
    }

    public function setAddcity($addcity) {
        $this->addcity = $addcity;
    }

    public function getAddcity() {
        return $this->addcity;
    }

    public function setAddcountry($addcountry) {
        $this->addcountry = $addcountry;
    }

    public function getAddcountry() {
        return $this->addcountry;
    }

    public function setAddPhone1($addphone1) {
        $this->addphone1 = $addphone1;
    }

    public function getAddPhone1() {
        return $this->addphone1;
    }

    public function setAddMobile($addmobile) {
        $this->addmobile = $addmobile;
    }

    public function setAddFax($addfax) {
        $this->addfax = $addfax;
    }

    public function getAddFax() {
        return $this->addfax;
    }

    public function getAddMobile() {
        return $this->addmobile;
    }

    public function setAddEmail($addemail) {
        $this->addemail = $addemail;
    }

    public function getAddEmail() {
        return $this->addemail;
    }

    public function setAddWebsite($addwebsite) {
        $this->addwebsite = $addwebsite;
    }

    public function getAddWebsite() {
        return $this->addwebsite;
    }

    /**
     * Set facebook
     *
     * @param string $linkedin
     * @return Contact
     */
    public function setLinkedin($linkedin) {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getLinkedin() {
        return $this->linkedin;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Contact
     */
    public function setFacebook($facebook) {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook() {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return Contact
     */
    public function setTwitter($twitter) {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter() {
        return $this->twitter;
    }

    /**
     * Set skype
     *
     * @param string $skype
     * @return Contact
     */
    public function setSkype($skype) {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get googleid
     *
     * @return string
     */
    public function getGoogleid() {
        return $this->googleid;
    }

    /**
     * Set linkedin
     *
     * @param string $googleid
     * @return Contact
     */
    public function setGoogleid($googleid) {
        $this->googleid = $googleid;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string
     */
    public function getSkype() {
        return $this->skype;
    }

    public function setAddNotes($addnotes) {
        $this->addnotes = $addnotes;
    }

    public function getAddNotes() {
        return $this->addnotes;
    }

    public function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }

    public function setCreationUser($creation_user) {
        $this->creation_user = $creation_user;
    }

    public function getCreationUser() {
        return $this->creation_user;
    }

}
