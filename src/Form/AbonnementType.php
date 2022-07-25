<?php

namespace App\Form;

use App\Entity\Abonnement;
use App\Entity\TypeAbonnement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'debut',
                DateType::class,
                ['widget' => 'single_text']
            )
            ->add(
                'fin',
                DateType::class,
                ['widget' => 'single_text']
            )
            ->add('statut', ChoiceType::class, [
                'placeholder' => "Selectionner le status",
                'choices' => Abonnement::STATUS,
                'attr' => [
                    'class' => 'select2'
                ],
            ])
            ->add(
                'typeAbonnement',
                EntityType::class,
                [
                    'class' => TypeAbonnement::class,
                    'placeholder' => 'Choisir un Type',
                    'choice_label' => 'designation',
                    'multiple' => false,
                    'mapped' => true,

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
