<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class FormData extends AbstractType
{
    public $url;

    public $submit;

    public $FirstName;

    public $LastName;

    public $Title;

    public $Department;

    public $OfficePhone;

    public $Mobile;

    public $Fax;

    public $PrimaryAddressStreet;

    public $PrimaryAddressCity;

    public $PrimaryAddressState;

    public $PrimaryAddressPostalCode;

    public $PrimaryAddressCountry;

    public $AlternateAddressStreet;

    public $AlternateAddressCity;

    public $AlternateAddressState;

    public $AlternateAddressPostalCode;

    public $AlternateAddressCountry;

    public $EmailAddress;

    public $Description;

    public $ReportsTo;

    public $LeadSource;

    public $Campaign;

    public $AssignedTo;
}
