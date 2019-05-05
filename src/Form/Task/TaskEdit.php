<?php

namespace App\Form\Task;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Contact;
use App\Form\FormData;
use App\Entity\Campaigns;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TaskEdit extends AbstractType
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
                'Status',
                ChoiceType::class,
                [
                    'choices' => [
                        'Not Started' => 'Not Started',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Pending Input' => 'Pending Input',
                        'Deferred' => 'Deferred',
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
            ->add('StartDate', DateTimeType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'form-control input-inline js-datepicker1',
                    'data-provide' => 'datetimepicker',
                    'html5' => false,

                ],
            ))
            ->add('DueDate', DateTimeType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'form-control input-inline js-datepicker2',
                    'data-provide' => 'datetimepicker',
                    'html5' => false,

                ],
            ))
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
            ->add('ContactName', EntityType::class, [
                'required' => false,
                'placeholder' => 'Choose an option',
                'label' => 'Contact Name',
                'class' => Contact::class,
                'choice_label' => 'FirstName',
                'choice_value' => 'Id',
                'mapped' => false,
            ])
            ->add('AssignedTo', EntityType::class, [
                'required' => false,
                'placeholder' => 'Choose an option',
                'label' => 'Assign to',
                'class' => User::class,
                'choice_label' => 'FirstName',
                'choice_value' => 'Id',
                'mapped' => false,
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
                'data_class' => Task::class
            ]
        );
    }
}
