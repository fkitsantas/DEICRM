<?php

namespace App\Form\Cases;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\FormData;
use App\Entity\Campaigns;
use App\Entity\Account;
use App\Entity\Contact;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CasesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'Subject',
                TextType::class,
                [

                    'attr' => [
                        'placeholder' => 'Subject',
                        'label' => ' '
                    ]
                ]
            )
            ->add('AccountName', EntityType::class, [
                'label' => 'Account Name',
                'class' => Account::class,
                'choice_label' => 'Name',
                'choice_value' => 'Id',
            ])
            ->add(
                'Type',
                ChoiceType::class,
                [
                    'choices' => [
                        'Administration' => 'Administration',
                        'Product' => 'Product',
                        'User' => 'User',
                    ]
                ]
            )
            ->add(
                'Description',
                TextareaType::class,
                [

                    'attr' => [
                        'placeholder' => 'Description',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'Status',
                ChoiceType::class,
                [
                    'choices' => [
                        'New' => 'New',
                        'Assigned' => 'Assigned',
                        'Closed' => 'Closed',
                        'Pending Input' => 'Pending Input',
                        'Rejected' => 'Rejected',
                        'Duplicate' => 'Duplicate',


                    ]
                ]
            )
            ->add(
                'Priority',
                ChoiceType::class,
                [
                    'choices' => [
                        'High' => 'High',
                        'Medium' => 'Medium',
                        'Low' => 'Low',


                    ]
                ]
            )
            ->add(
                'Resolution',
                TextareaType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Resolution',
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
                'data_class' => FormData::class
            ]
        );
    }
}
