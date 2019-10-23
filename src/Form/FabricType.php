<?php

namespace App\Form;

use App\Entity\Fabric;
use App\Entity\Type;
use App\Repository\TypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FabricType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Libellé du tissu']
            ])
            ->add('extensible', CheckboxType::class, [
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
            ->add('types', EntityType::class, [
                'label' => false,
                'class' => Type::class,
                'query_builder' => function (TypeRepository $repo) {
                    return $repo->createQueryBuilder('t')
                        ->andWhere('t.bool_fabric = 1')
                        ;
                },
                'required' => false,
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-none-selected-text' => 'Associer un ou plusieurs types',
                    'multiple' => true,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fabric::class,
        ]);
    }
}
