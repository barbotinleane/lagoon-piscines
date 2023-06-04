<?php

namespace App\Form;

use App\Entity\FAQ;
use App\Entity\FaqCategory;
use App\Entity\FormationCategory;
use App\Repository\FaqCategoryRepository;
use App\Repository\FormationCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FAQType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextType::class, [
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-12',
                ]
            ])
            ->add('answer', TextareaType::class, [
                'label' => 'Réponse',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'col-12',
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => FaqCategory::class,
                'query_builder' => function (FaqCategoryRepository $fcr) {
                    return $fcr->createQueryBuilder('fc')
                        ->orderBy('fc.name', 'ASC');
                },
                'label' => 'Catégorie',
                'choice_label' => 'name',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => ''
                ],
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FAQ::class,
        ]);
    }
}
