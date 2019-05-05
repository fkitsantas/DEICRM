<?php

namespace App\Form\Cases;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\FormData;
use App\Entity\Campaigns;
use App\Entity\Cases;
use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CasesCommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'AccountId',
                HiddenType::class,
                array('data' => $options['accountid'])
            )
            ->add(
                'AccountName',
                HiddenType::class,
                array('data' => $options['accountname'])
            )
            ->add(
                'CaseId',
                HiddenType::class,
                array('data' => $options['caseid'])
            )
            ->add(
                'AddedBy',
                HiddenType::class,
                array('data' => $options['addedby'])
            )
            ->add(
                'AddedById',
                HiddenType::class,
                array('data' => $options['addedbyid'])
            )
            ->add(
                'Comment',
                TextareaType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Add comments',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' =>
                        [
                            'class' => 'btn btn-primary btn-lg btn-block'
                        ]
                ]

            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => FormData::class,
                'caseid' => null,
                'accountid' => null,
                'accountname' => null,
                'addedby' => null,
                'addedbyid' => null,
                'type' => null,

            ]
        );
    }
}
