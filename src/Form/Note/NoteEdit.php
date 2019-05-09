<?php

namespace App\Form\Note;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Note;
use App\Form\FormData;
use App\Entity\Campaigns;
use App\Entity\Contact;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NoteEdit extends AbstractType
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
            ->add('ContactName', EntityType::class, [
                'required' => false,
                'placeholder' => 'Choose an option',
                'label' => 'Contact Name',
                'class' => Contact::class,
                'choice_label'  => function ($Contact) {
                    return sprintf('%s %s', $Contact->getFirstName(), $Contact->getLastName());
                },
                'choice_value' => 'Id',
                'mapped' => false,
            ])
            ->add(
                'Note',
                TextareaType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Note',
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
                'data_class' => Note::class
            ]
        );
    }
}
