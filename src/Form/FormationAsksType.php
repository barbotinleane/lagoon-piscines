<?php

namespace App\Form;

use App\Entity\FormationAsks;
use App\Entity\FormationSessions;
use App\Entity\Status;
use App\Repository\FormationSessionsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/***
 * Form related to FormationAsks entity to make a formation ask
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
class FormationAsksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
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
            ->add('phoneNumber', NumberType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ],
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'label' => 'Je suis... ',
                'attr' => [
                    'class' => 'buttons-group',
                    'role' => 'group',
                ],
                'expanded' => true
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'required' => false,
            ])
            ->add('companyPostalCode', NumberType::class, [
                'label' => 'Code postal du siège social',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'required' => false,
            ])
            ->add('numberOfWorkersInCompany', NumberType::class, [
                'label' => 'Nombre de salariés dans l\'entreprise',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'required' => false,
            ])
            ->add('knowsUs', ChoiceType::class, [
                'label' => 'J\'ai connu le centre de formation LAGOON® par...',
                'choices' => [
                    'Recommandation d\'un proche/collègue' => 'Recommandation d\'un proche/collègue',
                    'Article ou Publicité dans un magazine' => 'Article ou Publicité dans un magazine',
                    'Lors d’un salon' => 'Lors d’un salon',
                    'Par un site internet' => 'Par un site internet',
                    'Dans une boutique' => 'Dans une boutique',
                    'J\'ai reçu un mail' => 'J\'ai reçu un mail',
                    'Autre' => 'Autre',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('consents', ChoiceType::class, [
                'label' => ' ',
                'choices' => [
                    'En soumettant ce formulaire, j’accepte que mes informations soient utilisées exclusivement dans 
        le cadre de ma demande et de la relation commerciale éthique et personnalisée qui pourrait en découler 
        si je le souhaite et je reconnais avoir pris connaissance de la politique de traitement et d\'utilisation 
        des données relative à la RGPD disponible en cliquant ici.' => 1,
                    'J\'ai lu et j’accepte les Conditions Générales de Vente de LAGOON® DISTRIBUTION CORPORATION.' => 2,
                    'J\'ai été informé que si ma candidature est retenue, 30% du montant total de la formation est 
        nécessaire pour réserver ma (ou mes) place(s) ; le solde devant etre réglé au plus tard 15 jours avant le début de ma formation.' => 3
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
            ->add('numberOfLearners', IntegerType::class, [
                    'label' => 'Nombre de personnes à pré-inscrire à la formation',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label_attr' => [
                        'class' => 'form-label'
                    ],
                    'required' => true,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationAsks::class,
            'allow_extra_fields' => true,
        ]);
    }
}
