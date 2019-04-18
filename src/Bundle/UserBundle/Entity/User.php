<?php

// src/My/UserBundle/Entity/User.php

namespace CRM\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="FOSContactUsers")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
  
    /*adding other column below*/
    public function __construct() {
        parent::__construct();
        // your own logic
    }

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=150, nullable=true)
     */
    protected $fullname; 
    
    /**
     * @var string
     *
     * @ORM\Column(name="subscription", type="string", length=50, nullable=true)
     */
    protected $subscription;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=50, nullable=true)
     */
    protected $position;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    protected $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=20, nullable=true)
     */
    protected $mobile;

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
     * @ORM\Column(name="company_name", type="string", length=100, nullable=true)
     */
    protected $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="company_street", type="string", length=100, nullable=true)
     */
    protected $companyStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="company_city", type="string", length=100, nullable=true)
     */
    protected $companyCity;

    /**
     * @var string
     *
     * @ORM\Column(name="company_state", type="string", length=100, nullable=true)
     */
    protected $companyState;

    /**
     * @var string
     *
     * @ORM\Column(name="company_country", type="string", length=100, nullable=true)
     */
    protected $companyCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="company_email", type="string", length=100, nullable=true)
     */
    protected $companyEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="company_fax", type="string", length=100, nullable=true)
     */
    protected $companyFax;

    /**
     * @var string
     *
     * @ORM\Column(name="company_phone", type="string", length=100, nullable=true)
     */
    protected $companyPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="company_mobile", type="string", length=100, nullable=true)
     */
    protected $companyMobile;

    /**
     * @var string
     *
     * @ORM\Column(name="company_website", type="string", length=100, nullable=true)
     */
    protected $companyWebsite;

    /**
     * @var string
     *
     * @ORM\Column(name="shortdesc", type="string", length=150, nullable=true)
     */
    protected $shortdesc;

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     */
    protected $creation_date;

    /**
     * @ORM\Column(name="creation_user", type="string", length=150)
     */
    protected $creation_user;

    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    protected $google_id;

    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=100, nullable=true)
     */
    protected $theme;

    /**
     * Set fullname
     *
     * @param string $fullname
     * @return Users
     */
    public function setfullname($fullname) {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getfullname() {
        return $this->fullname;
    }
    
    /**
     * Set subscription
     *
     * @param string $subscription
     * @return Users
     */
    public function setSubscription($subscription) {
    	$this->subscription = $subscription;
    
    	return $this;
    }
    
    /**
     * Get subscription
     *
     * @return string
     */
    public function getSubscription() {
    	return $this->subscription;
    }
 

    /**
     * Set position
     *
     * @param string $position
     * @return Users
     */
    public function setPosition($position) {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return Users
     */
    public function setBirthdate($birthdate) {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate() {
        return $this->birthdate;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Users
     */
    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return Users
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Users
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
     * @return Users
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
     * @return Users
     */
    public function setSkype($skype) {
        $this->skype = $skype;

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

    /**
     * Set name
     *
     * @param string $name
     * @return Company
     */
    public function setCompanyName($companyName) {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getCompanyName() {
        return $this->companyName;
    }

    /**
     * Set companyStreet
     *
     * @param string $companyStreet
     * @return Company
     */
    public function setCompanyStreet($companyStreet) {
        $this->companyStreet = $companyStreet;

        return $this;
    }

    /**
     * Get companyStreet
     *
     * @return string 
     */
    public function getCompanyStreet() {
        return $this->companyStreet;
    }

    /**
     * Set companyCity
     *
     * @param string $companyCity
     * @return Company
     */
    public function setCompanyCity($companyCity) {
        $this->companyCity = $companyCity;

        return $this;
    }

    /**
     * Get companyCity
     *
     * @return string 
     */
    public function getCompanyCity() {
        return $this->companyCity;
    }

    /**
     * Set companyState
     *
     * @param string $companyState
     * @return Company
     */
    public function setCompanyState($companyState) {
        $this->companyState = $companyState;

        return $this;
    }

    /**
     * Get companyState
     *
     * @return string 
     */
    public function getCompanyState() {
        return $this->companyState;
    }

    /**
     * Set companyCountry
     *
     * @param string $companyCountry
     * @return Company
     */
    public function setCompanyCountry($companyCountry) {
        $this->companyCountry = $companyCountry;

        return $this;
    }

    /**
     * Get companyCountry
     *
     * @return string 
     */
    public function getCompanyCountry() {
        return $this->companyCountry;
    }

    /**
     * Set companyEmail
     *
     * @param string $companyEmail
     * @return Company
     */
    public function setCompanyEmail($companyEmail) {
        $this->companyEmail = $companyEmail;

        return $this;
    }

    /**
     * Get companyEmail
     *
     * @return string 
     */
    public function getCompanyEmail() {
        return $this->companyEmail;
    }

    /**
     * Set 
     *
     * @param string $companyPhone
     * @return Company
     */
    public function setCompanyPhone($companyPhone) {
        $this->companyPhone = $companyPhone;

        return $this;
    }

    /**
     * Get companyPhone
     *
     * @return string 
     */
    public function getCompanyPhone() {
        return $this->companyPhone;
    }

    /**
     * Set 
     *
     * @param string $companyPhone
     * @return Company
     */
    public function setCompanyFax($companyFax) {
        $this->companyFax = $companyFax;

        return $this;
    }

    /**
     * Get companyPhone
     *
     * @return string 
     */
    public function getCompanyFax() {
        return $this->companyFax;
    }

    /**
     * Set 
     *
     * @param string $companyMobile
     * @return Company
     */
    public function setCompanyMobile($companyMobile) {
        $this->companyMobile = $companyMobile;

        return $this;
    }

    /**
     * Get companyPhone
     *
     * @return string 
     */
    public function getCompanyMobile() {
        return $this->companyMobile;
    }

    /**
     * Set companyWebsite
     *
     * @param string $companyWebsite
     * @return Company
     */
    public function setCompanyWebsite($companyWebsite) {
        $this->companyWebsite = $companyWebsite;

        return $this;
    }

    /**
     * Get companyPhone
     *
     * @return string 
     */
    public function getCompanyWebsite() {
        return $this->companyWebsite;
    }

    /**
     * Set shordesc
     *
     * @param string $shortdesc
     * @return Users
     */
    public function setShortdesc($shortdesc) {
        $this->shortdesc = $shortdesc;

        return $this;
    }

    /**
     * Get shordesc
     *
     * @return string
     */
    public function getShortdesc() {
        return $this->shortdesc;
    }

    public function setCreationDate($creation_date) {
        $this->creation_date = $creation_date;
    }

    public function getCreationDate() {
        return $this->creation_date;
    }

    public function setCreationUser($creation_user) {
        $this->creation_user = $creation_user;
    }

    public function getCreationUser() {
        return $this->creation_user;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
    }

    public function getTheme() {
        return $this->theme;
    }
    
    

}
