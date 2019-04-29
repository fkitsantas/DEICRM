<?php

namespace App\Form\Campaigns;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Campaigns;
use App\Form\FormData;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CampaignsEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add(
              'Name',
              TextType::class,
              [

              'attr' => [
                  'placeholder' => 'Campaign Name',
                  'label' => ' '
              ]
              ]
          )
          ->add(
              'Status',
              ChoiceType::class,
              [
    'choices'  => [
        'Planning' => 'Planning',
        'Active' => 'Active',
        'Active' => 'Active',
        'Inactive' => 'Inactive',
        'Complete' => 'Complete',
        'InQueue' => 'In Queue',
        'Sending' => 'Sending',

    ]
  ]
          )
          ->add(
              'Type',
              ChoiceType::class,
              [
    'choices'  => [
        'Telesales' => 'Telesales',
        'Mail' => 'Mail',
        'Email' => 'Email',
        'Print' => 'Print',
        'Web' => 'Web',
        'Radio' => 'Radio',
        'Television' => 'Television',
        'Newsletter' => 'Newsletter',

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
    ->add('EndDate', DateTimeType::class, array(
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
  'Currency',
  ChoiceType::class,
  [
'choices'  => [
'US Dollar' => 'US Dollar $',
'Pound' => 'Pound £',
]
]
)

          ->add(
              'Impressions',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Impressions',
                  'label' => ' '
              ]
              ]
          )


          ->add(
              'ActualCost',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Actual Cost',
                  'label' => ' '
              ]
              ]
          )

          ->add(
              'ExpectedCost',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Expected Cost',
                  'label' => ' '
              ]
              ]
          )
          ->add(
              'ExpectedRevenue',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Expected Revenue',
                  'label' => ' '
              ]
              ]
          )
          ->add(
              'Objective',
              TextareaType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Objective',
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
              'label' => 'Assign to',
              'class' => User::class,
              'choice_label' => 'Username',
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
            'data_class' => Campaigns::class
            ]
        );
    }
}
