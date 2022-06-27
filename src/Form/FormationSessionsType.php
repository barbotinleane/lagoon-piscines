<?php

namespace App\Form;

use App\Entity\FormationLibelles;
use App\Entity\FormationSessions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationSessionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateStart', DateType::class, [
                'label' => 'Date de début',
                'row_attr' => [
                    'class' => 'col-12 col-sm-4'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'min' => ( new \DateTime() )->format('Y-m-d'),
                ],
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'Date de fin',
                'row_attr' => [
                    'class' => 'col-12 col-sm-4'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'min' => ( new \DateTime() )->format('Y-m-d'),
                ],
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('registered', NumberType::class, [
                'label' => 'Nombre d\'inscrits sur la session',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => ['class' => 'col-12 col-sm-4'],
            ])
            ->add('capacity', NumberType::class, [
                'label' => 'Capacité de la session',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => ['class' => 'col-12 col-sm-4'],
            ])
            ->add('formation', EntityType::class, [
                'class' => FormationLibelles::class,
                'choice_label' => 'libelle',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-select'
                ],
                'row_attr' => ['class' => 'col-12 col-sm-8'],
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
