<?php

namespace App\Form\Interaction;

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
use App\Entity\Interaction;
use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InteractionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


      ->add(
          'WhoTo',
      HiddenType::class,
      array('data' => $options['id'])
      )

      ->add(
          'Type',
      HiddenType::class,
      array('data' => $options['type'])
      )

      ->add(
          'WhoBy',
          HiddenType::class,
          array('data' => $options['whoby'])
            )

        ->add(
            'MediaType',
            ChoiceType::class,
            [
  'choices'  => [
      'Email' => 'Email',
      'Call' => 'Call',
      'Meeting' => 'Meeting',
      'Chat' => 'Chat',

  ]
]
        )



        ->add('FromDate', DateTimeType::class, array(
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
    'FromTime',
    ChoiceType::class,
    [
'choices'  => [
'12:00:00AM' => '12:00:00AM',
'1:00:00AM' => '1:00:00AM',
'2:00:00AM' => '2:00:00AM',
'3:00:00AM' => '3:00:00AM',
'4:00:00AM' => '4:00:00AM',
'5:00:00AM' => '5:00:00AM',
'6:00:00AM' => '6:00:00AM',
'7:00:00AM' => '7:00:00AM',
'8:00:00AM' => '8:00:00AM',
'9:00:00AM' => '9:00:00AM',
'10:00:00AM' => '10:00:00AM',
'11:00:00AM' => '11:00:00AM',
'12:00:00PM' => '12:00:00PM',
'1:00:00PM' => '1:00:00PM',
'2:00:00PM' => '2:00:00PM',
'3:00:00PM' => '3:00:00PM',
'4:00:00PM' => '4:00:00PM',
'5:00:00PM' => '5:00:00PM',
'6:00:00PM' => '6:00:00PM',
'7:00:00PM' => '7:00:00PM',
'8:00:00PM' => '8:00:00PM',
'9:00:00PM' => '9:00:00PM',
'10:00:00PM' => '10:00:00PM',
'11:00:00PM' => '11:00:00PM',
]
]
)

->add('ToDate', DateTimeType::class, array(
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
    'ToTime',
    ChoiceType::class,
    [
'choices'  => [
'12:00:00AM' => '12:00:00AM',
'1:00:00AM' => '1:00:00AM',
'2:00:00AM' => '2:00:00AM',
'3:00:00AM' => '3:00:00AM',
'4:00:00AM' => '4:00:00AM',
'5:00:00AM' => '5:00:00AM',
'6:00:00AM' => '6:00:00AM',
'7:00:00AM' => '7:00:00AM',
'8:00:00AM' => '8:00:00AM',
'9:00:00AM' => '9:00:00AM',
'10:00:00AM' => '10:00:00AM',
'11:00:00AM' => '11:00:00AM',
'12:00:00PM' => '12:00:00PM',
'12:00:00PM' => '12:00:00PM',
'1:00:00PM' => '1:00:00PM',
'2:00:00PM' => '2:00:00PM',
'3:00:00PM' => '3:00:00PM',
'4:00:00PM' => '4:00:00PM',
'5:00:00PM' => '5:00:00PM',
'6:00:00PM' => '6:00:00PM',
'7:00:00PM' => '7:00:00PM',
'8:00:00PM' => '8:00:00PM',
'9:00:00PM' => '9:00:00PM',
'10:00:00PM' => '10:00:00PM',
'11:00:00PM' => '11:00:00PM',
]
]
)

->add(
    'LineDurationL',
    ChoiceType::class,
    [
'choices'  => [
'0000d:00:00:30' => '0000d:00:00:30',
'0000d:00:01:00' => '0000d:00:01:00',
'0000d:00:05:00' => '0000d:00:05:00',
'0000d:00:10:00' => '0000d:00:10:00',
'0000d:00:30:00' => '0000d:00:30:00',
'0000d:00:60:00' => '0000d:00:60:00',
'0000d:01:00:00' => '0000d:01:00:00',
'0000d:02:00:00' => '0000d:02:00:00',
'0000d:03:00:00' => '0000d:03:00:00',
'0000d:06:00:00' => '0000d:06:00:00',
'0000d:06:00:00' => '0000d:06:00:00',
'0000d:12:00:00' => '0000d:12:00:00',
'0000d:15:00:00' => '0000d:15:00:00',
'0000d:24:00:00' => '0000d:24:00:00',
'0001d:00:00:00' => '0001d:00:00:00',
]
]
)


->add(
    'LineDurationS',
    ChoiceType::class,
    [
'choices'  => [
'9999d:00:00:00' => '9999d:00:00:00',
'00030d:00:00:00' => '00030d:00:00:00',
'0001d:00:00:00' => '0001d:00:00:00',
'00000:24:00:00' => '00000:24:00:00',
'0000d:12:00:00' => '0000d:12:00:00',
'0000d:8:00:00' => '0000d :8:00:00',
'0000d:05:00:00' => '0000d:05:00:00',
'0000d:03:00:00' => '0000d:03:00:00',
'0000d:02:00:00' => '0000d:02:00:00',
'0000d:01:00:00' => '0000d:01:00:00',
'0000d:00:59:00' => '0000d:00:59:00',
'0000d:00:45:00' => '0000d:00:45:00',
'0000d:00:30:00' => '0000d:00:30:00',
'0000d:00:15:00' => '0000d:00:15:00',
'0001d:00:08:00' => '0001d:00:08:00',
'0001d:00:05:00' => '0001d:00:05:00',
'0001d:00:01:00' => '0001d:00:01:00',
'0001d:00:00:59' => '0001d:00:00:59',
'0001d:00:00:30' => '0001d:00:00:30',
]
]
)

->add(
    'Direction',
    ChoiceType::class,
    [
'choices'  => [
'Inbound' => 'Inbound',
'Outbound' => 'Outbound',

]
]
)

          ->add(
              'RemoteAddress',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Remote Address',
                  'label' => ' '
              ]
              ]
          )
          ->add(
              'Dnis',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'Dnis',
                  'label' => ' '
              ]
              ]
          )
          ->add(
              'LastIc',
              TextType::class,
              [

                'required' => false,
              'attr' => [
                  'placeholder' => 'LastIc',
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
            'id' => null,
            'type' => null,
            'whoby' => null
            ]
        );
    }
}
