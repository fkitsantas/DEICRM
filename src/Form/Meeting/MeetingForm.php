<?php

namespace App\Form\Meeting;

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

class MeetingForm extends AbstractType
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
    'choices'  => [
        'Not Started' => 'Not Started',
        'In Progress' => 'In Progress',
        'Completed' => 'Completed',
        'Pending Input' => 'Pending Input',
        'Deferred' => 'Deferred',
    ]
  ]
          )

          ->add(
              'RelatedToType',
              ChoiceType::class,
              [
                'label' => 'Type',
    'choices'  => [
        'Account' => 'Account',
        'Contact' => 'Contact',
        'Lead' => 'Lead',
        'Opportunity' => 'Opportunity',
        'Case' => 'Case',
        'Target' => 'Target',
        'Meeting' => 'Meeting',
    ]
  ]
          )











                    ->add(
                        'RelatedTo',
                        EntityType::class,
                        [
                        'label' => 'Related To',
                        'class' => Contact::class,
                        'choice_label' => 'FirstName',
                        'choice_value' => 'Id',
                  ]
                    )


                ->add(
                    'AssignedTo',
                    EntityType::class,
                    [
                    'label' => 'Assign to',
                    'class' => User::class,
                    'choice_label' => 'Username',
                    'choice_value' => 'Id',
              ]
                )



          ->add(
              'Location',
              TextType::class,
              [
                'label' => 'Location',
                'required' => false,
              'attr' => [
                  'placeholder' => 'Location',
                  'label' => ' '
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
