<?php

/*
 * This software belongs to Rhea Software S.R.O. 
 * Any other information are specified in the software contract agreement. 
 */

namespace CRM\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MyProfileType extends AbstractType {

    /**
     * Builds the AddUser form
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('fullname'); 
        $builder->add('position', 'text', array('required' => false));
        $builder->add('phone', 'text', array('required' => false));
        $builder->add('mobile', 'text', array('required' => false));
        $builder->add('email', 'email', array('required' => false));
        $builder->add('birthdate', 'date', array(
            'widget' => 'single_text', 'required' => false));
        $builder->add('facebook', 'text', array('required' => false));
        $builder->add('twitter', 'text', array('required' => false));
        $builder->add('skype', 'text', array('required' => false));
        $builder->add('shortdesc', 'textarea', array('required' => false));
        $builder->add('enabled', 'choice', array(
            'choices' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'multiple' => false,
            'expanded' => false,
        ));
        $builder->add('password', 'password', array('required' => false)); 
        $builder->add('companyName', 'text', array('required' => false));
        $builder->add('companyStreet', 'text', array('required' => false));
        $builder->add('companyCity', 'text', array('required' => false));
        $builder->add('companyState', 'text', array('required' => false)); 
        $builder->add('companyCountry', 'country', array(
            'label' => 'Please', 'preferred_choices' => array('US')
        ));
        $builder->add('companyPhone', 'text', array('required' => false));
        $builder->add('companyFax', 'text', array('required' => false));
        $builder->add('companyMobile', 'text', array('required' => false));
        $builder->add('companyEmail', 'text', array('required' => false));
        $builder->add('companyWebsite', 'text', array('required' => false));
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'CRM\ContactBundle\Entity\User',
            'em' => '',
        );
    }

    public function getName() {
        return 'user';
    }

}
