<?php
namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\FormData;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserForm extends AbstractType
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
                'Password',
                TextType::class,
                [

                'attr' => [
                    'placeholder' => 'Password',
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
      'choices'  => [
          'Sales Manager' => 'ROLE_SALES_MANAGER',
          'Admin' => 'ROLE_ADMIN',
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
            'data_class' => FormData::class
            ]
        );
    }
}
