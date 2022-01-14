<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepLangueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'reponse',
                ChoiceType::class,
                [
                    'mapped' => false,
                    'expanded' => true,
                    'choices' =>
                    [
                        'oui' => 'oui',
                        'non' => 'non'
                    ],
                    'placeholder'=>'veuillez cocher oui pour ajouter une langue'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
