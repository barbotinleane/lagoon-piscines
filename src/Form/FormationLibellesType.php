<?php

namespace App\Form;

use App\Entity\FormationLibelles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FormationLibellesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Titre *',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('imageName', FileType::class, [
                'label' => 'Image de présentation *',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-12 col-sm-12',
                ],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image JPEG ou PNG non valide.',
                    ])
                ],
            ])
            ->add('agrement', ChoiceType::class, [
                'label' => 'La formation est agrémentée, toute personne peut effectuer une demande de formation *',
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'attr' => [
                    'class' => 'buttons-group',
                    'role' => 'group',
                ],
                'expanded' => true
            ])
            ->add('duration', TextType::class, [
                'label' => 'Durée *',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('cost', TextType::class, [
                'label' => 'Prix *',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('programNameOfFile', FileType::class, [
                'label' => 'Programme de la formation *',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-12 col-sm-12',
                ],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '70000k',
                        'mimeTypes' => [
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Fichier PDF non valide.',
                    ])
                ],
            ])
            ->add('presentation', TextareaType::class, [
                'label' => 'Présentation de la formation *',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-12 col-sm-12',
                ]
            ])
            ->add('place', TextType::class, [
                'label' => 'Lieu *',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('displayOnLagoonPiscines', ChoiceType::class, [
                'label' => 'Afficher la formation sur le site internet de Lagoon Piscines ? *',
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'attr' => [
                    'class' => 'buttons-group',
                    'role' => 'group',
                ],
                'expanded' => true
            ])
            ->add('satisfactionRate', IntegerType::class, [
                'required' => false,
                'label' => 'Taux de satisfaction',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ],
            ])
            ->add('individualSuccessRate', IntegerType::class, [
                'label' => 'Taux de réussite individuelle',
                'attr' => [
                    'class' => 'form-control',
                    'value' => null,
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'required' => false,
            ])
            ->add('companyApprovalRate', IntegerType::class, [
                'label' => 'Taux d\'agrément entreprise',
                'attr' => [
                    'class' => 'form-control',
                    'value' => null,
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'required' => false,
            ])
            ->add('formationGoals', CollectionType::class, [
                'entry_type' => FormationGoalsType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('formationImages', CollectionType::class, [
                'entry_type' => FormationImagesType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationLibelles::class,
        ]);
    }
}
