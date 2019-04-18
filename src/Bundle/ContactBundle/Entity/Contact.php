<?php

namespace CRM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use CRM\ContactBundle\Entity\ContactCatList;

/**
 * @ORM\Entity
 * @ORM\Table(name="Contacts")
 */
class Contact {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string", length=50, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="lname", type="string", length=50)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", name="fname", length=50)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", name="phone1", length=50, nullable=true)
     */
    protected $phone1;

    /**
     * @ORM\Column(type="string", name="phone2", length=50, nullable=true)
     */
    protected $phone2;

    /**
     * @ORM\Column(type="string", name="mobile", length=50, nullable=true)
     */
    protected $mobile;

    /**
     * @ORM\Column(type="string", name="fax", length=50, nullable=true)
     */
    protected $fax;

    /**
     * @ORM\Column(type="string", name="email", length=50)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", name="website", length=50, nullable=true, nullable=true)
     */
    protected $website;

    /**
     * @ORM\Column(type="string", name="jobtitle", length=50, nullable=true)
     */
    protected $jobtitle;

    /**
     * @ORM\Column(type="string", name="company", length=50, nullable=true, nullable=true)
     */
    protected $company;

    /**
     * @ORM\Column(type="string", name="street", length=100)
     */
    protected $street;

    /**
     * @ORM\Column(type="string", name="city", length=100)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", name="state", length=100)
     */
    protected $state;

    /**
     * @ORM\Column(type="string", name="country", length=100)
     */
    protected $country;

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
     * @ORM\Column(name="creation_date", type="datetime")
     */
    protected $dateAdded;

    /**
     * @ORM\Column(type="string", name="creation_user", length=150)
     */
    protected $creation_user;

    /**
     * @ORM\Column(type="string", name="status", length=10)
     */
    protected $status;

    /**
     * @ORM\Column(type="string", name="notes", length=1000, nullable=true)
     */
    protected $addnotes;

    /**
     * @ORM\OneToMany(targetEntity="ContactCatList", mappedBy="contact", cascade={"all"})
     * */
    protected $catlist;
    protected $categories;

    public function __construct() {
        $this->catlist = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    // Getters and Setters

    public function __toString() {
        return $this->name;
    }

    // Important 
    public function getCategory() {
        $categories = new ArrayCollection();

        foreach ($this->catlist as $c) {
            $categories[] = $c->getCategory();
        }

        return $categories;
    }

    // Important
    public function setCategory($categories) {
        foreach ($categories as $c) {
            $catlist = new ContactCatList();

            $catlist->setContact($this);
            $catlist->setCategory($c);

            $this->addCatList($catlist);
        }
    }

    public function getContact() {
        return $this;
    }

    public function getCatList() {
        return $this->catlist;
    }

    public function addCatList($ContactCatList) {
        $this->catlist[] = $ContactCatList;
    }

    public function removeCatList($ContactCatList) {
        return $this->catlist->removeElement($ContactCatList);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setFirstName($firstname) {
        $this->firstname = $firstname;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function setLastName($lastname) {
        $this->lastname = $lastname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function setPhone1($phone1) {
        $this->phone1 = $phone1;
    }

    public function getPhone1() {
        return $this->phone1;
    }

    public function setPhone2($phone2) {
        $this->phone2 = $phone2;
    }

    public function getPhone2() {
        return $this->phone2;
    }

    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    public function setFax($fax) {
        $this->fax = $fax;
    }

    public function getFax() {
        return $this->fax;
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function setJobTitle($jobtitle) {
        $this->jobtitle = $jobtitle;
    }

    public function getJobTitle() {
        return $this->jobtitle;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function getStreet() {
        return $this->street;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getCity() {
        return $this->city;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getState() {
        return $this->state;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getCountry() {
        return $this->country;
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

    public function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setCreationUser($creation_user) {
        $this->creation_user = $creation_user;
    }

    public function getCreationUser() {
        return $this->creation_user;
    }

    public function setAddNotes($addnotes) {
        $this->addnotes = $addnotes;
    }

    public function getAddNotes() {
        return $this->addnotes;
    }
}
