<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ModelCv;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ModelCvType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('prix')
             ->add('createur',EntityType::class,[
                 'class'=>User::class,
                 'mapped'=>true,
                 'expanded'=>false,
                 'multiple'=>false,
                 'choice_label'=> function ($user){
                    return $user->getPersonne()->getFirstName().' '.$user->getPersonne()->getLastName();
                }
             ])
        ;
    }
     
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModelCv::class,
        ]);
    }
}
