<?php

namespace App\Form;

use App\Entity\Asks;
use App\Entity\FormationLibelles;
use App\Entity\FormationSessions;
use App\Repository\FormationLibellesRepository;
use App\Entity\Status;
use App\Repository\FormationSessionsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/***
 * Form related to Asks entity to make a formation ask
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
class AsksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $departmentsNames = [];

        foreach ($options['departments'] as $department) {
            $departmentsNames[$department->getName()] = $department->getCode();
        }

        $builder
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'label' => 'Vous êtes...',
                'attr' => [
                    'class' => 'buttons-group',
                    'role' => 'group',
                ],
                'expanded' => true
            ])
            ->add('activityCategory', ChoiceType::class, [
                'label' => 'Catégorie d\'Activité',
                'choices' => [
                    'Aménagement Paysager' => 'Aménagement Paysager',
                    'Application de résine' => 'Application de résine',
                    'Terrassement' => 'Terrassement',
                    'Construction' => 'Construction',
                    'Piscine' => 'Piscine',
                    'Autre' => 'Autre',
                ],
                'choice_attr' => function() {
                    return ['class' => 'form_check_input'];
                },
                'row_attr' => [
                    'class' => 'form-check',
                ],
                'expanded' => true
            ])
            ->add('goal', ChoiceType::class, [
                'choices' => [
                    'Reconversion professionnelle' => 'Reconversion professionnelle',
                    'Création d\'une entreprise' => 'Création d\'une entreprise',
                    'Création d\'un département LAGOON® dans votre entreprise' => 'Création d\'un département LAGOON® dans votre entreprise',
                    'Simplement acquérir les compétences liées à cette formation' => 'Simplement acquérir les compétences liées à cette formation',
                    'Autre' => 'Autre',
                ],
                'choice_attr' => function() {
                    return ['class' => 'form_check_input'];
                },
                'row_attr' => [
                    'class' => 'form-check',
                ],
                'label' => 'Quel est votre objectif :',
                'expanded' => true
            ])
            ->add('formationSession', EntityType::class, [
                'class' => FormationSessions::class,
                'query_builder' => function (FormationSessionsRepository $fsr) {
                    return $fsr->createQueryBuilder('fs')
                        ->where('fs.dateStart >= :now')
                        ->andWhere('fs.formation = 1')
                        ->setParameter('now', new \DateTimeImmutable());
                },
                'expanded' => true,
                'label' => 'Date de formation souhaitée : ',
                'placeholder' => 'Choisissez une date...'
            ])
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
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('address',  TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('postalCode',  NumberType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('city',  TextType::class, [
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
            ->add('handicap', CheckboxType::class, [
                'attr' => [
                    'value' => 'null',
                    'class' => 'form-check-input'
                ],
                'label' => 'Je suis en situation de handicap, je souhaite que vous étudiiez les solutions possibles pour que j\'accède à cette formation.',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'required' => false,
            ])
            ->add('knowsUs', ChoiceType::class, [
                'label' => 'Comment avez-vous connu notre centre de formation ?',
                'choices' => [
                    'Recommandation par un proche/collègue' => 'Recommandation par un proche/collègue',
                    'Article ou Publicité dans un magazine' => 'Article ou Publicité dans un magazine',
                    'Lors d’un salon' => 'Lors d’un salon',
                    'Par un site internet' => 'Par un site internet',
                    'Dans une boutique' => 'Dans une boutique',
                    'Autre' => 'Autre',
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('consents', ChoiceType::class, [
                'label' => 'Consentements',
                'choices' => [
                    'En soumettant ce formulaire, j’accepte que mes informations soient utilisées exclusivement dans 
                    le cadre de ma demande et de la relation commerciale éthique et personnalisée qui pourrait en découler 
                    si je le souhaite et je reconnais avoir pris connaissance de la politique de traitement et d\'utilisation 
                    des données relative à la RGPD disponible en cliquant ici.' => 1,
                    'J\'ai lu et j’accepte les Conditions Générales de Vente de LAGOON® DISTRIBUTION CORPORATION.' => 2,
                    'J\'ai été informé que si ma candidature est retenue, 30% du montant total de la formation est 
                    nécessaire pour valider définitivement mon inscription ; le solde total devant être réglé avant 
                    le début de la formation. ' => 3
                ],
                'mapped' => false,
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'attr' => [
                    'class' => 'form-check'
                ],
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'attr' => [
                    'value' => 'null',
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('sirenOrRm', TextType::class, [
                'label' => 'SIREN ou RM',
                'attr' => [
                    'value' => 'null',
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('idPoleEmploi', TextType::class, [
                'label' => 'Identifiant Pole Emploi',
                'attr' => [
                    'value' => 'null',
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('siret', TextType::class, [
                'label' => 'SIRET',
                'attr' => [
                    'value' => 'null',
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('prerequisites', TextType::class, [
                'attr' => [
                    'value' => 'null',
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('stagiaires', CollectionType::class, [
                'entry_type' => StagiairesType::class,
                'entry_options' => ['label' => 'Les stagiaires'],
                'allow_add' => true,
                'attr' => ['value' => 'null']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
                'disabled' => true,
                'attr' => [
                    'class' => 'btn btn-lg btn-blue mt-5',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Asks::class,
            'departments' => null,
            'formation' => null,
        ]);
    }
}
