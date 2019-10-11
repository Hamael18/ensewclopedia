<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', EntityType::class, [
                'label' => false,
                'class' => Role::class,
                'multiple' => false,
                'required'=> true,
                'attr' => [
                    'class' => 'selectpicker',
                    'multiple' => false,
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un rôle'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
