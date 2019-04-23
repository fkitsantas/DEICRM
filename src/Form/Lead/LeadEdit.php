<?php

namespace App\Form\Lead;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Lead;
use App\Form\FormData;
use App\Entity\Campaigns;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LeadEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add(
              'FirstName',
              TextType::class,
              [

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

                'required' => false,
              'attr' => [
                  'placeholder' => 'Email Address',
                  'label' => ' '
              ]
              ]
          )
          ->add(
              'Description',
              TextareaType::class,
              [

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
              'LeadSourceDescription',
              TextareaType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Lead Source Description',
                  'label' => ' '
              ]
              ]
          )

          ->add(
              'Status',
              ChoiceType::class,
              [
              'required' => false,
    'choices'  => [
        'New' => 'New',
        'Assigned' => 'Assigned',
        'In Process' => 'In Process',
        'Converted' => 'Converted',
        'Recycled' => 'Recycled',
        'Dead' => 'Dead'




    ]
  ]
          )

          ->add(
              'StatusDescription',
              TextareaType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Status Description',
                  'label' => ' '
              ]
              ]
          )

          ->add('Campaign', EntityType::class, [
              'class' => Campaigns::class,
              'choice_label' => 'Name',
              'choice_value' => 'Id'
  ])

          ->add(
              'AssignedTo',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Assign to',
                  'label' => ' '
              ]
              ]
          )

          ->add(
              'ReferredBy',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Referred by',
                  'label' => ' '
              ]
              ]
          )
          ->add(
              'OpportunityAmount',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Opportunity Amount',
                  'label' => ' '
              ]
              ]
          )
          ->add('Campaign', EntityType::class, [
              'class' => Campaigns::class,
              'choice_label' => 'Name',
              'choice_value' => 'Id'
  ])

          ->add(
              'submit',
              SubmitType::class

          );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            'data_class' => Lead::class
            ]
        );
    }
}
