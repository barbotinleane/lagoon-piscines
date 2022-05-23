<?php

namespace App\Form;

use App\Entity\PoolColor;
use App\Entity\PoolShape;
use App\Entity\ProjectAsk;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectAskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $departmentsNames = [];

        foreach ($options['departments'] as $department) {
            $departmentsNames[$department->getName()] = $department->getCode();
        }

        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('phone', NumberType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('postalCode', NumberType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('department',  ChoiceType::class, [
                'label' => 'Département',
                'choices' => $departmentsNames,
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('waterSurface', ChoiceType::class, [
                'label' => 'Nombre de mètres carrés de surface d\'eau :',
                'choices' => [
                    '25 m²' => '25 m²',
                    '30 m²' => '30 m²',
                    '40 m²' => '40 m²',
                    '50 m²' => '50 m²',
                    '60 m²' => '60 m²',
                    '70 m²' => '70 m²',
                    '80 m²' => '80 m²',
                    '99 m²' => '99 m²',
                ],
                'choice_attr' => function() {
                    return ['class' => 'form_check_input'];
                },
                'attr' => [
                    'class' => 'buttons-group',
                ],
                'expanded' => true
            ])
            ->add('shape', ChoiceType::class, [
                'label' => 'Forme de la piscine : ',
                'choices' => [
                    'Modèle pré-dessiné' => 'Modèle pré-dessiné',
                    'Modèle sur-mesure' => 'Modèle sur-mesure',
                ],
                'choice_attr' => function() {
                    return ['class' => 'form_check_input'];
                },
                'attr' => [
                    'class' => 'buttons-group',
                ],
                'expanded' => true
            ])
            ->add('poolModel', EntityType::class, [
                'class' => PoolShape::class,
                'label' => 'Forme de la piscine : ',
                'attr' => [
                    'class' => 'buttons-group',
                    'role' => 'group',
                ],
                'expanded' => true
            ])
            ->add('poolColor', EntityType::class, [
                'class' => PoolColor::class,
                'label' => 'Couleur de la piscine (revêtement) : ',
                'attr' => [
                    'class' => 'buttons-group',
                    'role' => 'group',
                ],
                'expanded' => true
            ])
            ->add('beach', ChoiceType::class, [
                'label' => 'Forme de la piscine : ',
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'choice_attr' => function() {
                    return ['class' => 'form_check_input'];
                },
                'attr' => [
                    'class' => 'buttons-group',
                ],
                'expanded' => true
            ])
            ->add('beachSize', ChoiceType::class, [
                'label' => 'Taille de la plage :',
                'choices' => [
                    '5 m²' => '5 m²',
                    '10 m²' => '10 m²',
                    '15 m²' => '15 m²',
                    '20 m²' => '20 m²',
                ],
                'choice_attr' => function() {
                    return ['class' => 'form_check_input'];
                },
                'attr' => [
                    'class' => 'buttons-group',
                ],
                'expanded' => true
            ])
            ->add('beachColor', EntityType::class, [
                'class' => PoolColor::class,
                'label' => 'Couleur de la plage (revêtement) : ',
                'attr' => [
                    'class' => 'buttons-group',
                    'role' => 'group',
                ],
                'expanded' => true
            ])
            ->add('filtrationType', ChoiceType::class, [
                'label' => 'Type de filtration souhaité :',
                'choices' => [
                    'UV' => 'UV',
                    'Electrolyse au sel' => 'Electrolyse au sel',
                    'Système écologique' => 'Système écologique',
                    'Je ne sais pas encore' => 'Je ne sais pas encore',
                ],
                'choice_attr' => function() {
                    return ['class' => 'form_check_input'];
                },
                'attr' => [
                    'class' => 'buttons-group',
                ],
                'expanded' => true
            ])
            ->add('heatPump', ChoiceType::class, [
                'label' => 'Pompe à chaleur : ',
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'choice_attr' => function() {
                    return ['class' => 'form_check_input'];
                },
                'attr' => [
                    'class' => 'buttons-group',
                ],
                'expanded' => true
            ])
            ->add('buildingStarts', DateType::class, [
                'label' => 'Début de construction souhaité :',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('budget', TextType::class, [
                'label' => 'Budget alloué au projet (facultatif) : ',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Dites nous en plus sur votre projet...',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectAsk::class,
            'departments' => null,
        ]);
    }
}
