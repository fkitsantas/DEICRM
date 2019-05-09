<?php

namespace App\Form\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use App\Entity\Contact;
use App\Form\FormData;
use App\Entity\Campaigns;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContactEdit extends AbstractType
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
            ->add('ContactName', EntityType::class, [
                'required' => false,
                'placeholder' => 'Choose an option',
                'label' => 'Contact Name',
                'class' => Contact::class,
                'choice_label' => 'FirstName',
                'choice_value' => 'Id',
                'mapped' => false,
            ])
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
            ->add('AssignedTo', EntityType::class, [
                'required' => false,
                'placeholder' => 'Choose an option',
                'label' => 'Assign to',
                'class' => User::class,
                'choice_label'  => function ($User) {
                    return sprintf('%s %s', $User->getFirstName(), $User->getLastName());
                },
                'choice_value' => 'Id',
                'mapped' => false,
            ])
            ->add(
                'LeadSource',
                ChoiceType::class,
                [
                    'choices' => [
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
                'submit',
                SubmitType::class

            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Contact::class
            ]
        );
    }
}
