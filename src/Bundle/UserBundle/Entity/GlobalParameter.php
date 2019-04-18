<?php

namespace CRM\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="GlobalParameters")
 */
class GlobalParameter {

    /**
     * @var integer
     *
     * @ORM\Column(name="parameter_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $parameterId;
 

    /**
     * @var string
     *
     * @ORM\Column(name="parameter_code", type="string", length=100, nullable=false)
     */
    protected $parameterCode;

    /**
     * @var string
     *
     * @ORM\Column(name="parameter_value", type="string", length=100, nullable=true)
     */
    protected $parameterValue;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=true)
     */
    protected $description;
 

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     */
    protected $createdDate;

    /**
     *
     * @ORM\Column(name="creationUser", type="string", length=50, nullable=true)
     */
    protected $creationUser;

    /**
     * Get parameterId
     *
     * @return integer 
     */
    public function getParameterId() {
        return $this->parameterId;
    }
 
    /**
     * Set parameterCode
     *
     * @param string $parameterCode
     * @return Globalparameters
     */
    public function setParameterCode($parameterCode) {
        $this->parameterCode = $parameterCode;

        return $this;
    }

    /**
     * Get parameterCode
     *
     * @return string 
     */
    public function getParameterCode() {
        return $this->parameterCode;
    }

    /**
     * Set parameterValue
     *
     * @param string $parameterValue
     * @return Globalparameters
     */
    public function setParameterValue($parameterValue) {
        $this->parameterValue = $parameterValue;

        return $this;
    }

    /**
     * Get parameterValue
     *
     * @return string 
     */
    public function getParameterValue() {
        return $this->parameterValue;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Globalparameters
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set enabled
     *
     * @param string $enabled
     * @return Globalparameters
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return string 
     */
    public function getEnabled() {
        return $this->enabled;
    }
    
     public function setCreatedDate($createdDate) {
        $this->createdDate = $createdDate;

        return $this;
    }
 
    public function getCreatedDate() {
        return $this->createdDate;
    }

    public function setCreationUser($creationUser) {
        $this->creationUser = $creationUser;
    }

    public function getCreationUser() {
        return $this->creationUser;
    }

}
