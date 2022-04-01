<?php

namespace App\Form;

use App\Entity\UserForCv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserForCvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add(
                'avatar'
                
            )
            ->add('sexe',ChoiceType::class,[
                'choices'=>[
                'Homme'=>'homme',
                'Femme'=>'femme']
            ])
            ->add('poste_recherche_occupe');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserForCv::class,
        ]);
    }
}