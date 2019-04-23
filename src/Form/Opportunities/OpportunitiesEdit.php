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
use App\Entity\Opportunities;
use App\Form\FormData;
use App\Entity\Campaigns;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OpportunitiesEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'OpportunityName',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Opportunity Name',
                    'label' => ' '
                ]
                ]
            )
            ->add(
                'AccountName',
                TextType::class,
                [

                'attr' => [
                    'placeholder' => 'Account Name',
                    'label' => ' '
                ]
                ]
            )
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
      'attr' => [
          'class' => 'form-control input-inline datetimepicker',
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
                'required' => false,
      'choices'  => [
          'Prospecting' => 'Prospecting',
          'Qualification' => 'Qualificatio',
          'NeedsAnalysis' => 'Needs Analysis',
          'ValueProposition' => 'Value Proposition',
          'Id.Decision Makers' => 'Id. Decision Makers',
          'PerceptionAnalysis' => 'Perception Analysis',
          'Proposal/PriceQuote' => 'Proposal/Price Quote',
          'Negotiation/Review' => 'Negotiation/Review',
          'ClosedWon' => 'Closed Won',
          'ClosedLost' => 'Closed Lost',



      ]
    ]
            )
            ->add(
                'LeadSource',
                ChoiceType::class,
                [
                'required' => false,
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
            ->add(
                'AssignedTo',
                TextType::class,
                [

                  'required' => false,
                'attr' => [
                    'placeholder' => 'Assign to',
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
            'data_class' => Opportunities::class
            ]
        );
    }
}
