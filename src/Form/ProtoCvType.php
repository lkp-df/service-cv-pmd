<?php

namespace App\Form;

use App\Entity\MonProtoCv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProtoCvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,['attr'=>["placeholder"=>"votre nom",'require'=>true]])
            ->add('prenom',TextType::class,['attr'=>["placeholder"=>"votre prénom",'require'=>true]])
            ->add('email',EmailType::class,['attr'=>["placeholder"=>"votre Email",'require'=>true]])
            ->add('adresse',TextType::class,['attr'=>["placeholder"=>"votre adresse",'require'=>true]])
            ->add('tel',TextType::class,['attr'=>["placeholder"=>"votre tél",'require'=>true]])
            ->add('poste',TextType::class,['attr'=>["placeholder"=>"votre poste",'require'=>true]])
            ->add('profil',TextareaType::class,['attr'=>["placeholder"=>"votre profil",'require'=>true]])
            ->add(
                'avatar',
                FileType::class,
                [
                    'label' => 'avatar jpg or png',
                    'multiple' => false,
                    'mapped'=>true,
                    'required' => false,
                    'constraints' =>
                    [
                        new File(
                            [
                                'maxSize' => '1024k',
                                'mimeTypes' =>
                                [
                                    'image/jpeg',
                                    'image/jpg',
                                    'image/png'
                                ],
                                'mimeTypesMessage'=>'Veuillez choisir une image valide',
                            ],
                        )
                    ]
                ]
            )
            ->add('sexe',ChoiceType::class,[
                'choices'=>[
                'Homme'=>'homme',
                'Femme'=>'femme']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class'=>MonProtoCv::class
        ]);
    }
}