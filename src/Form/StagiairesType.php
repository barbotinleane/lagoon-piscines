<?php

namespace App\Form;

use App\Entity\Stagiaires;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/***
 * Form related to Stagiaires entity to add a stagiaire in the ask for a formation.
 * Used when the asker is a company director and wants to susbcribe his employees to the formation.
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
class StagiairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('phoneNumber', NumberType::class, [
                'label' => 'Numéro de Téléphone'
            ])
            ->add('currentJob', TextType::class, [
                'label' => 'Poste occupé et depuis combien de temps'
            ])
            ->add('handicap', CheckboxType::class, [
                'label' => 'Stagiaire en situation de handicap, je souhaite que vous étudiiez les solutions possibles pour qu\'il accède à cette formation.',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaires::class,
        ]);
    }
}
