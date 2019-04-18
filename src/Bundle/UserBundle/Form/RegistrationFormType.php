<?php

namespace CRM\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // add your custom field
        $builder->add('fullname');
    }

    public function getParent() {
        return 'fos_user_registration';
    }

    public function getName() {
        return 'crm_user_registration';
    }

}
