<?php

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use App\Form\FormData;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'Intials',
                TextType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Intial',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'FirstName',
                TextType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'First name',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'LastName',
                TextType::class,
                [

                    'attr' => [
                        'placeholder' => 'Last name',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'Email',
                TextType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Email Address',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'Roles',
                ChoiceType::class,
                [
                    'choices' => [
                        'Employee' => 'ROLE_EMPLOYEE',
                        'Manager' => 'ROLE_MANAGER',
                        'Administrator' => 'ROLE_ADMIN',
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class

            );

        $builder->get('Roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    return implode(', ', $tagsAsArray);
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class
            ]
        );
    }
}
