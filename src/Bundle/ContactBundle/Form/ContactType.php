<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CRM\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType {

    /**
     * Builds the AddContact form
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     * @return void
     */
    
     public function __construct($creationUser) { 
        $this->creation_user = $creationUser;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', 'text', array('required' => false));
        $builder->add('firstname');
        $builder->add('lastname');
        $builder->add('phone1', 'text', array('required' => false));
        $builder->add('phone2', 'text', array('required' => false));
        $builder->add('mobile', 'text', array('required' => false));
        $builder->add('fax', 'text', array('required' => false));
        $builder->add('email');
        $builder->add('website', 'text', array('required' => false));
        $builder->add('status', 'choice', array(
            'choices' => array(
                'S' => 'Standard',
                'V' => 'VIP',
                'B' => 'Blacklist'
            ),
            'required' => true,
            'empty_data' => 'S'
        ));
        $builder->add('jobtitle', 'text', array('required' => false));
        $builder->add('company', 'text', array('required' => false));
        $builder->add('street');
        $builder->add('city');
        $builder->add('state');
        $builder->add('country', 'country', array(
            'label' => 'Please', 'preferred_choices' => array('US')
        ));
        $builder->add('linkedin', 'text', array('required' => false));
        $builder->add('facebook', 'text', array('required' => false));
        $builder->add('twitter', 'text', array('required' => false));
        $builder->add('skype', 'text', array('required' => false));
        $builder->add('googleid', 'text', array('required' => false));
        $builder->add('Category', 'entity', array(
            'class' => 'CRMContactBundle:Category',
            'property' => 'name',
            'multiple' => true,
            'expanded' => true,
            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) {
                return $repository->createQueryBuilder('s')
                                ->where('s.creationUser = ?1')
                                ->setParameter(1, $this->creation_user)
                                ->add('orderBy', 's.id ASC');
            }
        ));
        $builder->add('addnotes', 'textarea', array('required' => false));
    }

    /**
     * Returns the default options/class for this form.
     * @param array $options
     * @return array The default options
     */
    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'CRM\ContactBundle\Entity\Contact',
            'em' => '',
        );
    }

    /**
     * Mandatory in Symfony2
     * Gets the unique name of this form.
     * @return string
     */
    public function getName() {
        return 'contact';
    }

}
