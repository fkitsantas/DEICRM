<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'FirstName',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'First name',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'LastName',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Last name',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'Title',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Title',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'Department',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Department',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'OfficePhone',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Office Phone',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'Mobile',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Mobile',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'Fax',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'fax',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'PrimaryAddressStreet',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Address Street',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'PrimaryAddressCity',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Address city',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'PrimaryAddressState',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Address state',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'PrimaryAddressPostalCode',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Postal code',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'PrimaryAddressCountry',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Primary address country',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'AlternateAddressStreet',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Alternative address street',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'AlternateAddressCity',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Alternative address city',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'AlternateAddressState',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Alternative address state',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'AlternateAddressPostalCode',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Alternative address postal code',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'AlternateAddressCountry',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Alternative address country',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'EmailAddress',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Email Address',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'Description',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Description',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'ReportsTo',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Reports to',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'LeadSource',
                ChoiceType::class,
                [
                'required' => false,
      'choices'  => [
          'cold call' => 'cold call',
          'Existing Customer' => 'Existing Customer',
          'Self Generated' => 'Self Generated',
          'Employee' => 'Employee',
          'Partner' => 'Partner',
          'Public Relations' => 'Public Relations',
          'Direct Mail' => 'Direct Mail',
          'Conference' => 'Conference',
          'Trade Show' => 'Trade Show',
          'Website' => 'Website',
          'Word of Mouth' => 'Word of Mouth',
          'Email' => 'Email',
          'Campaign' => 'Campaign',
          'Other' => 'Other',



      ]
    ]
            )
            ->add(
                'Campaign',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Campaign',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'AssignedTo',
                TextType::class,
                [
                  'label' => false,
                  'required' => false,
                'attr' => [
                    'placeholder' => 'Assigned to',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class

            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            'data_class' => FormData::class
            ]
        );
    }
}
