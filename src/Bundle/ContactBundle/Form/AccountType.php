<?php

/*
 * This application belongs to Rhea Software (rheasoftware.com)
 * Illegal distribution is prohibited and punishable by law.  * 
 */

namespace CRM\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AccountType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text', array('required' => true));
        $builder->add('accounttype', 'choice', array(
            'choices' => array(
                'A' => 'Active',
                'P' => 'Prospect',
                'B' => 'Blacklist'
            ),
            'required' => true,
            'empty_data' => 'A'
        ));
        $builder->add('manager', 'text', array('required' => true));
        $builder->add('shortdesc', 'textarea');
        $builder->add('primaryname', 'text');
        $builder->add('primaryemail', 'email');
        $builder->add('primaryphone', 'text'); 
        $builder->add('addstreet', 'text', array('required' => false));
        $builder->add('addstate', 'text', array('required' => false));
        $builder->add('addcity', 'text', array('required' => false));
        $builder->add('addcountry', 'country', array(
            'label' => 'Please', 'preferred_choices' => array('US')
        ));
        $builder->add('linkedin', 'text', array('required' => false));
        $builder->add('facebook', 'text', array('required' => false));
        $builder->add('twitter', 'text', array('required' => false));
        $builder->add('skype', 'text', array('required' => false));
        $builder->add('googleid', 'text', array('required' => false));
        $builder->add('addphone1', 'text', array('required' => false));
        $builder->add('addmobile', 'text', array('required' => false));
        $builder->add('addfax', 'text', array('required' => false));
        $builder->add('addemail', 'email', array('required' => false));
        $builder->add('addwebsite', 'text', array('required' => false));
        $builder->add('addnotes', 'textarea', array('required' => false));
    }

    /**
     * Returns the default options/class for this form.
     * @param array $options
     * @return array The default options
     */
    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'CRM\SaleBundle\Entity\Account',
            'em' => '',
        );
    }

    /**
     * Mandatory in Symfony2
     * Gets the unique name of this form.
     * @return string
     */
    public function getName() {
        return 'account';
    }

}
