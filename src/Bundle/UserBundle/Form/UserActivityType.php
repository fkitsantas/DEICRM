<?php

/*
 * This software belongs to Rhea Software S.R.O. 
 * Any other information are specified in the software contract agreement. 
 */

namespace CRM\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserActivityType extends AbstractType {
 
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('activity_desc'); 
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'CRM\UserBundle\Entity\UserActivity',
            'em' => '',
        );
    }

    public function getName() {
        return 'activity';
    }

}
