<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProtoCvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,['attr'=>["placeholder"=>"votre nom",'require'=>true]])
            ->add('prenom',TextType::class,['attr'=>["placeholder"=>"votre prénom",'require'=>true]])
            ->add('email',TextType::class,['attr'=>["placeholder"=>"votre Email",'require'=>true]])
            ->add('adresse',TextType::class,['attr'=>["placeholder"=>"votre adresse",'require'=>true]])
            ->add('tel',TextType::class,['attr'=>["placeholder"=>"votre tél",'require'=>true]])
            ->add('poste',TextType::class,['attr'=>["placeholder"=>"votre poste",'require'=>true]])
            ->add('avatar',FileType::class,['attr'=>['require'=>false]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
