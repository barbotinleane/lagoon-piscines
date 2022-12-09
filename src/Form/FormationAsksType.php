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
        $departmentsNames = [];

        foreach ($options['departments'] as $department) {
            $departmentsNames[$department->getName()] = $department->getCode();
        }

        $formationId = $options['formationId'];

        switch ($options['flow_step']) {
            case 1:
                $builder->add('status', EntityType::class, [
                    'class' => Status::class,
                    'label' => 'Je suis... *',
                    'attr' => [
                        'class' => 'buttons-group',
                        'role' => 'group',
                    ],
                    'expanded' => true
                ])
                ->add('goal', ChoiceType::class, [
                    'choices' => [
                        'Acquérir les compétences liées à cette formation et postuler auprès d\'entreprise installatrice de piscine LAGON' => 'Acquérir les compétences liées à cette formation et postuler auprès d\'entreprise installatrice de piscine LAGON',
                        'Créer une entreprise installatrice de piscine LAGON' => 'Créer une entreprise installatrice de piscine LAGON',
                        'Créer un département LAGON dans mon entreprise et installer des piscines LAGON' => 'Créer un département LAGON dans mon entreprise et installer des piscines LAGON',
                        'Créer une piscine LAGON chez moi' => 'Créer une piscine LAGON chez moi',
                        'Autre' => 'Autre',
                    ],
                    'choice_attr' => function() {
                        return ['class' => 'form_check_input'];
                    },
                    'row_attr' => [
                        'class' => 'form-check',
                    ],
                    'label' => 'Mon objectif ',
                    'expanded' => true
                ]);
                break;
            case 2:
                $builder
                    ->add('formationSession', EntityType::class, [
                        'class' => FormationSessions::class,
                        'query_builder' => function (FormationSessionsRepository $fsr) use($options) {
                            return $fsr->createQueryBuilder('fs')
                                ->where('fs.dateStart >= :now')
                                ->setParameter('now', new \DateTimeImmutable())
                                ->andWhere('fs.formation = :formationId')
                                ->setParameter('formationId', $options['formationId']);
                        },
                        'expanded' => true,
                        'label' => 'Date de formation souhaitée *',
                        'placeholder' => 'Choisissez une date...',
                        'attr' => [
                            'class' => 'buttons-group',
                            'role' => 'group',
                        ],
                        'choice_attr' => function($choice, $key, $value) {
                            if($choice->getRegistered() === $choice->getCapacity()) {
                                return ['disabled' => 1];
                            }
                            return [];
                        },
                    ]);
                break;
            case 3:
                $builder->add('firstName', TextType::class, [
                        'label' => 'Prénom *',
                        'attr' => [
                            'class' => 'form-control',
                        ],
                        'label_attr' => [
                            'class' => 'form-label'
                        ]
                    ])
                    ->add('lastName', TextType::class, [
                        'label' => 'Nom *',
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'label_attr' => [
                            'class' => 'form-label'
                        ]
                    ])
                    ->add('dateOfBirth', DateType::class, [
                        'label' => 'Date de naissance *',
                        'row_attr' => [
                            'class' => 'col-12 col-sm-4'
                        ],
                        'attr' => [
                            'class' => 'form-control',
                            'max' => ( new \DateTime() )->format('Y-m-d'),
                        ],
                        'widget' => 'single_text',
                        'input' => 'string',
                        'html5' => true,
                    ])
                    ->add('placeOfBirth', TextType::class, [
                        'label' => 'Lieu de naissance *',
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'label_attr' => [
                            'class' => 'form-label'
                        ]
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'Email *',
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'label_attr' => [
                            'class' => 'form-label'
                        ]
                    ])
                    ->add('phoneNumber', NumberType::class, [
                        'label' => 'Téléphone *',
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'label_attr' => [
                            'class' => 'form-label'
                        ],
                    ])
                    ->add('address',  TextType::class, [
                        'label' => 'Adresse *',
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'label_attr' => [
                            'class' => 'form-label'
                        ]
                    ])
                    ->add('postalCode',  NumberType::class, [
                        'label' => 'Code Postal *',
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'label_attr' => [
                            'class' => 'form-label'
                        ]
                    ])
                    ->add('city',  TextType::class, [
                        'label' => 'Ville *',
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'label_attr' => [
                            'class' => 'form-label'
                        ]
                    ])
                    ->add('department',  ChoiceType::class, [
                        'label' => 'Département *',
                        'label_attr' => [
                            'class' => 'form-label'
                        ],
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
                        ],
                        'required' => false,
                    ])
                    ->add('activityCategory', ChoiceType::class, [
                        'label' => 'Catégorie d\'Activité Actuelle',
                        'label_attr' => [
                            'class' => 'form-label'
                        ],
                        'choices' => [
                            'Piscinier' => 'Piscinier',
                            'Paysagiste' => 'Paysagiste',
                            'Etancheur' => 'Etancheur',
                            'Façadier' => 'Façadier',
                            'Carreleur' => 'Carreleur',
                            'Plombier' => 'Plombier',
                            'Applicateur de résine' => 'Applicateur de résine',
                            'Terrassier' => 'Terrassier',
                            'Autre' => 'Autre',
                        ],
                        'choice_attr' => function() {
                            return ['class' => 'form_check_input'];
                        },
                        'row_attr' => [
                            'class' => 'form-check',
                        ],
                        'expanded' => true,
                        "multiple" => true,
                    ])
                    ->add('handicap', CheckboxType::class, [
                        'attr' => [
                            'class' => 'form-check-input',
                        ],
                        'row_attr' => [
                            'class' => 'form-check',
                        ],
                        'label' => 'Je suis en situation de handicap, je souhaite que vous étudiiez les solutions possibles pour que j\'accède à cette formation.',
                        'label_attr' => [
                            'class' => 'form-check-label'
                        ],
                        'required' => false,
                    ]);

                switch($options['data']->getStatus()->getId()) {
                    case 1 :
                        $builder->add('sirenOrRm', TextType::class, [
                                'label' => 'SIREN ou RM *',
                                'attr' => [
                                    'class' => 'form-control'
                                ],
                                'label_attr' => [
                                    'class' => 'form-label'
                                ]
                            ])
                        ->add('companyName', TextType::class, [
                            'label' => 'Nom de l\'entreprise *',
                            'attr' => [
                                'class' => 'form-control'
                            ],
                            'label_attr' => [
                                'class' => 'form-label'
                            ],
                            'required' => true,
                        ])
                        ->add('companyAddress', TextType::class, [
                            'label' => 'Siège social *',
                            'attr' => [
                                'class' => 'form-control'
                            ],
                            'label_attr' => [
                                'class' => 'form-label'
                            ]
                        ])
                        ->add('companyPostalCode', NumberType::class, [
                            'label' => 'Code Postal',
                            'attr' => [
                                'class' => 'form-control'
                            ],
                            'label_attr' => [
                                'class' => 'form-label'
                            ],
                            'required' => false,
                        ])
                        ->add('companyCity', TextType::class, [
                            'label' => 'Ville *',
                            'attr' => [
                                'class' => 'form-control'
                            ],
                            'label_attr' => [
                                'class' => 'form-label'
                            ]
                        ])
                        ->add('companyCountry', TextType::class, [
                            'label' => 'Pays',
                            'attr' => [
                                'class' => 'form-control'
                            ],
                            'label_attr' => [
                                'class' => 'form-label'
                            ],
                            'required' => false,
                        ])
                        ->remove('handicap')
                        ->remove('address')
                        ->remove('postalCode')
                        ->remove('city')
                        ->remove('country')
                        ->remove('email')
                        ->remove('phoneNumber')
                        ->remove('department');
                        break;
                    case 2 :
                        $builder->add('idPoleEmploi', TextType::class, [
                            'label' => 'Identifiant Pole Emploi *',
                            'attr' => [
                                'class' => 'form-control'
                            ],
                            'label_attr' => [
                                'class' => 'form-label'
                            ]
                        ])
                        ->remove('activityCategory');
                        break;
                    case 3 :
                        $builder->add('sirenOrRm', TextType::class, [
                            'label' => 'SIREN ou RM *',
                            'attr' => [
                                'class' => 'form-control'
                            ],
                            'label_attr' => [
                                'class' => 'form-label'
                            ]
                        ]);
                        break;
                    case 4 :
                        $builder->add('siret', TextType::class, [
                            'label' => 'SIRET *',
                            'attr' => [
                                'class' => 'form-control'
                            ],
                            'label_attr' => [
                                'class' => 'form-label'
                            ]
                        ]);
                        break;
                    default :
                        break;
                }
                break;
            case 4 :
                $builder->add('isStagiaireMultiple', ChoiceType::class, [
                    'label' => 'Souhaitez-vous préinscrire plusieurs stagiaires de votre entreprise à cette formation ? *',
                    'choices' => [
                        'Oui' => 1,
                        'Non, que moi' => 0,
                    ],
                    'attr' => [
                        'class' => 'buttons-group',
                        'role' => 'group',
                    ],
                    'expanded' => true
                ]);
                break;
            case 5 :
                $builder
                ->add('stagiaires', CollectionType::class, [
                    'entry_type' => StagiairesType::class,
                    'label' => false,
                    'entry_options' => [
                        'label' => ' ',
                        'attr' => ['class' => 'row order-3 order-lg-2'],
                    ],
                    'allow_add' => true,
                    'attr' => [
                        'value' => 'null'
                    ],
                    'allow_delete' => true,
                ]);
                break;
            case 6 :
                $builder->add('knowsUs', ChoiceType::class, [
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
                ->add('funding', ChoiceType::class, [
                    'label' => 'Je pense financer la formation par... *',
                    'choices' => [
                        'Mes fonds personnels' => 'Mes fonds personnels',
                        'Les fonds de formation des entreprises' => 'Les fonds de formation des entreprises',
                        'Le financement Pôle Emploi/Région' => 'Le financement Pôle Emploi/Région',
                        'Un financement mixte' => 'Un financement mixte',
                        'Je ne sais pas encore' => 'Je ne sais pas encore',
                    ],
                    'multiple' => false,
                    'expanded' => true,
                    'required' => true,
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
                ->add('mathematics', CheckboxType::class, [
                    'attr' => [
                        'class' => 'form-check-input',
                    ],
                    'row_attr' => [
                        'class' => 'form-check',
                    ],
                    'label' => 'Je ne suis pas allergique aux mathématiques de base (+, -, x, :...)',
                    'label_attr' => [
                        'class' => 'form-check-label'
                    ],
                    'required' => false,
                ]);

                if($options['data']->getStatus()->getId() === 1 && $options['data']->isIsStagiaireMultiple() === false) {
                    $builder->add('handicap', CheckboxType::class, [
                        'attr' => [
                            'class' => 'form-check-input',
                        ],
                        'row_attr' => [
                            'class' => 'form-check',
                        ],
                        'label' => 'Je suis en situation de handicap, je souhaite que vous étudiiez les solutions possibles pour que j\'accède à cette formation.',
                        'label_attr' => [
                            'class' => 'form-check-label'
                        ],
                        'required' => false,
                    ]);
                }
                break;
            case 7 :
                $builder->add('consents', ChoiceType::class, [
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
                ]);
                break;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationAsks::class,
            'departments' => [],
            'formation' => null,
            'formationId' => null,
            'status' => null,
            'allow_extra_fields' => true,
        ]);
    }
}
