<?php

namespace App\Form\Email;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\FormData;
use App\Entity\Account;
use App\Entity\Contact;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EmailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'Subject',
                TextType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Subject',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'Message',
                TextareaType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Email',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'Type',
                ChoiceType::class,
                [
                    'choices' => [
                        'Account' => 'Account',
                        'Contact' => 'Contact',
                        'Lead' => 'Lead',
                        'Target' => 'Target',


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
                'data_class' => FormData::class,
                'allow_extra_fields' => true,
            ]
        );
    }
}
