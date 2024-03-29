<?php

namespace App\Form\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\FormData;
use App\Entity\Campaigns;
use App\Entity\User;
use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContactForm extends AbstractType
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
            ->add('ReportsTo', EntityType::class, [

                'required' => false,
                'placeholder' => 'Choose an option',
                'label' => 'Report to',
                'class' => Contact::class,
                'choice_label'  => function ($Contact) {
                    return sprintf('%s %s', $Contact->getFirstName(), $Contact->getLastName());
                },
                'choice_value' => 'Id',
            ])
            ->add(
                'LeadSource',
                ChoiceType::class,
                [
                    'placeholder' => 'Choose an option',
                    'required' => false,
                    'placeholder' => 'Choose an option',
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
            ->add('Campaign', EntityType::class, [
                'required' => false,
                'placeholder' => 'Choose an option',
                'class' => Campaigns::class,
                'choice_label' => 'Name',
                'choice_value' => 'Id',
            ])
            ->add('AssignedTo', EntityType::class, [
                'required' => false,
                'placeholder' => 'Choose an option',
                'label' => 'Assign to',
                'class' => User::class,
                'choice_label'  => function ($User) {
                    return sprintf('%s %s', $User->getFirstName(), $User->getLastName());
                },
                'choice_value' => 'Id',
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' =>
                        [
                            'class' => 'btn btn-primary btn-lg btn-block'
                        ]
                ]
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
