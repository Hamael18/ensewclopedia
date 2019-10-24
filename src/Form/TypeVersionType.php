<?php

namespace App\Form;

use App\Entity\Pattern;
use App\Entity\Type;
use App\Entity\Version;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TypeVersionType extends AbstractType
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
            ->add('type', EntityType::class, [
                'label' => false,
                'class' => Type::class,
                'multiple' => false,
                'required' => true,
                'attr' => [
                    'class' => 'selectpicker',
                    'multiple' => false,
                    'data-live-search' => false,
                    'title' => 'Choisir un type',
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
