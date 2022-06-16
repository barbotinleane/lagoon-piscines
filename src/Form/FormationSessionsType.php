<?php

namespace App\Form;

use App\Entity\FormationLibelles;
use App\Entity\FormationSessions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationSessionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateStart', DateType::class, [
                'label' => 'Date de début',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'Date de fin',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('registered', NumberType::class, [
                'label' => 'Inscrits',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('capacity', NumberType::class, [
                'label' => 'Capacité',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('formation', EntityType::class, [
                'class' => FormationLibelles::class,
                'choice_label' => 'libelle',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationSessions::class,
        ]);
    }
}
