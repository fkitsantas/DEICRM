<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeadForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Username',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'officephone',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Office Phone',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'fax',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'fax',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Email Address',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'billingaddress',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Billing Street',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'billingcity',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Billing City',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'billingstate',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Billing State',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'postalcode',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Postal Code',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'billingcountry',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Billing Country',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'shippingstreet',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Shipping Street',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'shippingcity',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Shipping City',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'shippingstate',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Shipping State',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'shippingpostalcode',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Shipping Postal Code',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'shippingcountry',
                TextType::class,
                [
                  'label' => false,
                'attr' => [
                    'placeholder' => 'Shipping Country',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'description',
                TextType::class,
                [
                  'label' => false,
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
            'data_class' => FormData::class
            ]
        );
    }
}
