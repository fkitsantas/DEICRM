<?php

namespace App\Form\Target;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Target;
use App\Form\FormData;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TargetEdit extends AbstractType
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
            ->add('AssignedTo', EntityType::class, [
                'label' => 'Assign to',
                'class' => User::class,
                'choice_label'  => function ($User) {
                    return sprintf('%s %s', $User->getFirstName(), $User->getLastName());
                },
                'choice_value' => 'Id',
                'mapped' => false,
            ])
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
                TextareaType::class,
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
                'submit',
                SubmitType::class

            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Target::class
            ]
        );
    }
}
