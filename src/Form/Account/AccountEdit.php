<?php

namespace App\Form\Account;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Account;
use App\Form\FormData;
use App\Entity\Campaigns;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AccountEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'Name',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Name',
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
                'Website',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Website',
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
                'BillingAddressStreet',
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
                'BillingAddressCity',
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
                'BillingAddressState',
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
                'BillingAddressPostalCode',
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
                'BillingAddressCountry',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Billing address country',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'ShippingAddressStreet',
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
                'ShippingAddressCity',
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
                'ShippingAddressState',
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
                'ShippingAddressPostalCode',
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
                'ShippingAddressCountry',
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
                'Type',
                TextareaType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Type',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'AnnualRevenue',
                TextareaType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Annual Revenue',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'SICCode',
                TextareaType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'SIC Code',
                    'label' => ' '
                ]
                ]
            )


            ->add(
                'Industry',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Industry',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'Employees',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Employees',
                    'label' => ' '
                ]
                ]
            )

            ->add(
                'TickerSymbol',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'TickerSymbol',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'Ownership',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Ownership',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'Rating',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Rating',
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
            'data_class' => Account::class
            ]
        );
    }
}
