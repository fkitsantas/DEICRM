<?php

namespace App\Form\Cases;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\FormData;

class CasesSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'Search',
                SearchType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Search Cases',
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
