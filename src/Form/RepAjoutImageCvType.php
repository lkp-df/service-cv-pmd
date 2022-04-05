<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepAjoutImageCvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reponse',
            ChoiceType::class,
            [
                'mapped' => false,
                'expanded' => true,
                'choices' =>
                [
                    'oui' => 'oui',
                    'non' => 'non'
                ],
                'placeholder'=>'modifier l\'image'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}