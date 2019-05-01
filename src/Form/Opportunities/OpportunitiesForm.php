<?php

namespace App\Form\Opportunities;

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
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OpportunitiesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'OpportunityName',
                TextType::class,
                [

                'attr' => [
                    'placeholder' => 'Opportunity Name',
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
                'Currency',
                ChoiceType::class,
                [
      'choices'  => [
          'US Dollar' => 'US Dollar $',
          'Pound' => 'Pound £',
      ]
    ]
            )


                ->add('ExpectedCloseDate', DateTimeType::class, array(
      'required' => true,
      'widget' => 'single_text',
      'format' => 'yyyy-MM-dd',
      'attr' => [
          'class' => 'form-control input-inline js-datepicker1',
          'data-provide' => 'datetimepicker',
          'html5' => false,

      ],
      ))
            ->add(
                'OpportunityAmount',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Opportunity Amount',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'Type',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Type',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'SalesStage',
                ChoiceType::class,
                [
      'choices'  => [
          'Prospecting' => 'Prospecting',
          'Qualification' => 'Qualificatio',
          'NeedsAnalysis' => 'Needs Analysis',
          'ValueProposition' => 'Value Proposition',
          'Id.Decision Makers' => 'Id. Decision Makers',
          'PerceptionAnalysis' => 'Perception Analysis',
          'Proposal/PriceQuote' => 'Proposal/Price Quote',
          'Negotiation/Review' => 'Negotiation/Review',
          'Closed/Won' => 'Closed Won',
          'Closed/Lost' => 'Closed Lost',



      ]
    ]
            )
            ->add(
                'LeadSource',
                ChoiceType::class,
                [
          'choices'  => [
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
            ->add(
                'Probability',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Probability %',
                    'label' => ' '
                ]
                ]
            )
            ->add('Campaign', EntityType::class, [
              'required' => false,
              'placeholder' => 'Choose an option',
                'class' => Campaigns::class,
                'choice_label' => 'Name',
                'choice_value' => 'Id'
    ])

            ->add(
                'NextStep',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Next Step',
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
