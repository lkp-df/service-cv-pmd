<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class,[
                'label'=>'Client (*)',
                'class'=>User::class,
                'choice_label'=>'email',
                'placeholder'=>'Selectionner le client'
            ])
            ->add('number')
            ->add('note',TextareaType::class)
            ->add('state',ChoiceType::class,[
                'choices'=>Commande::STATE
            ])
            ->add('total')
            ->add('items_total')
            ->add('adjustments_total')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
            'translation_domain'=>'forms'
        ]);
    }
}
