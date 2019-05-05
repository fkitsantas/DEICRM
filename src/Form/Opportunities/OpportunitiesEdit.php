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
use App\Entity\Contact;
use App\Entity\Account;
use App\Entity\User;
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
            ->add('AccountName', EntityType::class, [
                'required' => false,
                'placeholder' => 'Choose an option',
                'label' => 'Account Name',
                'class' => Account::class,
                'choice_label' => 'Name',
                'choice_value' => 'Id',
                'mapped' => false,
            ])
            ->add(
                'Currency',
                ChoiceType::class,
                [
                    'choices' => [
                        'US Dollar' => 'US Dollar $',
                        'Pound' => 'Pound £',
                    ]
                ]
            )
            ->add('ExpectedCloseDate', DateTimeType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control input-inline datetimepicker1',
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
            ->add('ContactName', EntityType::class, [
                'required' => false,
                'placeholder' => 'Choose an option',
                'label' => 'Contact Name',
                'class' => Contact::class,
                'choice_label' => 'FirstName',
                'choice_value' => 'Id',
                'mapped' => false,
            ])
            ->add(
                'SalesStage',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
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
                'LeadSource',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
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
