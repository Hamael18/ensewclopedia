<?php

namespace App\Form;

use App\Entity\Collar;
use App\Entity\Fabric;
use App\Entity\Handle;
use App\Entity\Length;
use App\Entity\Level;
use App\Entity\Pattern;
use App\Entity\Size;
use App\Entity\Style;
use App\Entity\Version;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isNew = (!$builder->getData()->getPattern());
        if ($isNew) {
            $builder
            ->add('pattern', EntityType::class, [
                'label' => false,
                'class' => Pattern::class,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un patron de couture'
                ]
            ])
        ;
        }
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nom de la version']
            ])
            ->add('imageFile', VichImageType::class, [
                'required'=>false,
                'label' => false,
                'attr' => ['placeholder' => 'Sélectionnez une image']
            ])
            ->add('collars', EntityType::class, [
                'label' => false,
                'class' => Collar::class,
                'multiple' => true,
                'required'=>false,
                'attr' => [
                    'class' => 'selectpicker',
                    'multiple' => true,
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un type de col'
                ]
            ])
            ->add('lengths', EntityType::class, [
                'label' => false,
                'class' => Length::class,
                'multiple' => true,
                'required'=>false,
                'attr' => [
                    'class' => 'selectpicker',
                    'multiple' => true,
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir une longueur'
                ]
            ])
            ->add('handles', EntityType::class, [
                'label' => false,
                'class' => Handle::class,
                'multiple' => true,
                'required'=>false,
                'attr' => [
                    'class' => 'selectpicker',
                    'multiple' => true,
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un type de manches'
                ]
            ])
            ->add('level', EntityType::class, [
                'label' => false,
                'class' => Level::class,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir une difficulté*'
                ]
            ])
            ->add('fabrics', EntityType::class, [
                'label' => false,
                'class' => Fabric::class,
                'multiple' => true,
                'required'=>false,
                'attr' => [
                    'class' => 'selectpicker',
                    'multiple' => true,
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un tissu'
                ]
            ])
            ->add('styles', EntityType::class, [
                'label' => false,
                'class' => Style::class,
                'multiple' => true,
                'required'=>false,
                'attr' => [
                    'class' => 'selectpicker',
                    'multiple' => true,
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir un style'
                ]
            ])
            ->add('sizes', EntityType::class, [
                'label' => false,
                'class' => Size::class,
                'multiple' => true,
                'required'=>false,
                'attr' => [
                    'class' => 'selectpicker test-control-search',
                    'multiple' => true,
                    'data-actions-box' => true,
                    'data-live-search' => true,
                    'data-multiple-separator' => ' | ',
                    'data-live-search-placeholder' => 'Recherche',
                    'data-none-selected-text' => 'Choisir un ou plusieurs taille(s)'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Version::class,
        ]);
    }
}
