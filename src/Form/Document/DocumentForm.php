<?php

namespace App\Form\Document;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\FormData;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DocumentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'FileName',
                FileType::class,
                ['label' => 'Document (PDF file)']
            )
            ->add(
                'DocumentName',
                TextType::class,
                [


                    'attr' => [
                        'placeholder' => 'Document Name',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'Status',
                ChoiceType::class,
                [
                    'required' => false,
                    'placeholder' => 'Choose an option',
                    'choices' => [
                        'Active' => 'Active',
                        'Draft' => 'Draft',
                        'FAQ' => 'FAQ',
                        'Expired' => 'Expired',
                        'Under Review' => 'Under Review',
                        'Pending' => 'Pending',
                    ]
                ]
            )
            ->add(
                'Category',
                ChoiceType::class,
                [
                    'required' => false,
                    'placeholder' => 'Choose an option',
                    'choices' => [
                        'Marketing' => 'Marketing',
                        'Knowledge Base' => 'Knowledge Base',
                        'Sales' => 'Sales',
                    ]
                ]
            )
            ->add(
                'SubCategory',
                ChoiceType::class,
                [
                    'required' => false,
                    'placeholder' => 'Choose an option',
                    'choices' => [
                        'Marketing Collateral' => 'Marketing Collateral',
                        'Product Brochures' => 'Product Brochures',
                        'FAQ' => 'FAQ',
                    ]
                ]
            )
            ->add(
                'DocumentType',
                ChoiceType::class,
                [
                    'required' => false,
                    'placeholder' => 'Choose an option',
                    'choices' => [
                        'Mail Merge' => 'Mail Merge',
                        'EULA' => 'EULA',
                        'NDA' => 'NDA',
                        'License Agreement' => 'License Agreement',
                    ]
                ]
            )
            ->add(
                'Revision',
                TextType::class,
                [

                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Revision',
                        'label' => ' '
                    ]
                ]
            )
            ->add(
                'AssignedTo',
                EntityType::class,
                [
                    'required' => false,
                    'placeholder' => 'Choose an option',
                    'label' => 'Assign to',
                    'class' => User::class,
                    'choice_label'  => function ($User) {
                        return sprintf('%s %s', $User->getFirstName(), $User->getLastName());
                    },
                    'choice_value' => 'Id',
                ]
            )
            ->add(
                'Description',
                TextareaType::class,
                [
                    'required' => false,
                    'label' => 'Description',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Description',
                        'label' => ' '
                    ]
                ]
            )
            ->add('PublishDate', DateTimeType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'form-control input-inline js-datepicker1',
                    'data-provide' => 'datetimepicker',
                    'html5' => false,

                ],
            ))
            ->add('ExpirationDate', DateTimeType::class, array(
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
                'submit',
                SubmitType::class
            );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => FormData::class,
                'allow_extra_fields' => true,
            ]
        );
    }
}
