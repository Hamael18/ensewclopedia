<?php

namespace App\Form;

use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AddTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Libellé du type']
            ])
            ->add('bool_length', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'success',
                    'data-on' => 'Oui',
                    'data-off' => 'Non',
                    'data-width' => "100"
                ]
            ])
            ->add('bool_level', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'success',
                    'data-on' => 'Oui',
                    'data-off' => 'Non',
                    'data-width' => "100"
                ]
            ])
            ->add('bool_handle', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'success',
                    'data-on' => 'Oui',
                    'data-off' => 'Non',
                    'data-width' => "100"
                ]
            ])
            ->add('bool_size', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'success',
                    'data-on' => 'Oui',
                    'data-off' => 'Non',
                    'data-width' => "100"
                ]
            ])
            ->add('bool_collar', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'success',
                    'data-on' => 'Oui',
                    'data-off' => 'Non',
                    'data-width' => "100"
                ]
            ])
            ->add('bool_fabric', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'success',
                    'data-on' => 'Oui',
                    'data-off' => 'Non',
                    'data-width' => "100"
                ]
            ])
            ->add('bool_style', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'success',
                    'data-on' => 'Oui',
                    'data-off' => 'Non',
                    'data-width' => "100"
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required'=>true,
                'label' => false,
                'attr' => ['placeholder' => 'Sélectionnez une image']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Type::class,
        ]);
    }
}
