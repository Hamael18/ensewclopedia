<?php

namespace App\Form;

use App\Entity\Collar;
use App\Entity\Fabric;
use App\Entity\Handle;
use App\Entity\Length;
use App\Entity\Level;
use App\Entity\Size;
use App\Entity\Style;
use App\Entity\Type;
use App\Entity\Version;
use App\Repository\CollarRepository;
use App\Repository\FabricRepository;
use App\Repository\HandleRepository;
use App\Repository\LengthRepository;
use App\Repository\SizeRepository;
use App\Repository\StyleRepository;
use App\Repository\TypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VersionType extends AbstractType
{
    private $type;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $version = $builder->getData();
        $this->type = $version->getType();

        if ($version->getType()->getBoolCollar() == 1) {
            $builder
                ->add('collars', EntityType::class, [
                    'label' => false,
                    'class' => Type::class,
//                    'query_builder' => function (TypeRepository $repository) {
//                        return $repository->createQueryBuilder('type')
//                            ->andWhere('type.collars = :type')
//                            ->andWhere('type', $this->type);
//                    },
                    'multiple' => true,
                    'required'=>false,
                    'attr' => [
                        'class' => 'selectpicker',
                        'multiple' => true,
                        'data-live-search' => true,
                        'data-none-selected-text' => 'Choisir un type de col'
                    ]
                ]);
        }

        if ($version->getType()->getBoolLength() == 1) {
            $builder
                ->add('lengths', EntityType::class, [
                    'label' => false,
                    'class' => Length::class,
                    'query_builder' => function (LengthRepository $repository) {
                        return $repository->createQueryBuilder('item')
                            ->join('item.types', 't')
                            ->andWhere('t.id = :type')
                            ->setParameter('type', $this->type);
                    },
                    'multiple' => true,
                    'required'=>false,
                    'attr' => [
                        'class' => 'selectpicker',
                        'multiple' => true,
                        'data-live-search' => true,
                        'data-none-selected-text' => 'Choisir une longueur'
                    ]
                ]);
        }

        if ($version->getType()->getBoolHandle() == 1) {
            $builder
                ->add('handles', EntityType::class, [
                    'label' => false,
                    'class' => Handle::class,
                    'query_builder' => function (HandleRepository $repository) {
                        return $repository->createQueryBuilder('item')
                            ->join('item.types', 't')
                            ->andWhere('t.id = :type')
                            ->setParameter('type', $this->type);
                    },
                    'multiple' => true,
                    'required'=>false,
                    'attr' => [
                        'class' => 'selectpicker',
                        'multiple' => true,
                        'data-live-search' => true,
                        'data-none-selected-text' => 'Choisir un type de manches'
                    ]
                ]);
        }


        if ($version->getType()->getBoolFabric()) {
            $builder
                ->add('fabrics', EntityType::class, [
                    'label' => false,
                    'class' => Fabric::class,
                    'query_builder' => function (FabricRepository $repository) {
                        return $repository->createQueryBuilder('item')
                            ->join('item.types', 't')
                            ->andWhere('t.id = :type')
                            ->setParameter('type', $this->type);
                    },
                    'multiple' => true,
                    'required'=>false,
                    'attr' => [
                        'class' => 'selectpicker',
                        'multiple' => true,
                        'data-live-search' => true,
                        'data-none-selected-text' => 'Choisir un tissu'
                    ]
                ]);
        }

        if ($version->getType()->getBoolStyle()) {
            $builder
                ->add('styles', EntityType::class, [
                    'label' => false,
                    'class' => Style::class,
                    'query_builder' => function (StyleRepository $repository) {
                        return $repository->createQueryBuilder('item')
                            ->join('item.types', 't')
                            ->andWhere('t.id = :type')
                            ->setParameter('type', $this->type);
                    },
                    'multiple' => true,
                    'required'=>false,
                    'attr' => [
                        'class' => 'selectpicker',
                        'multiple' => true,
                        'data-live-search' => true,
                        'data-none-selected-text' => 'Choisir un style'
                    ]
                ]);
        }

        if ($version->getType()->getBoolSize()) {
            $builder
                ->add('sizes', EntityType::class, [
                    'label' => false,
                    'class' => Size::class,
                    'query_builder' => function (SizeRepository $repository) {
                        return $repository->createQueryBuilder('item')
                            ->join('item.types', 't')
                            ->andWhere('t.id = :type')
                            ->setParameter('type', $this->type);
                    },
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

        $builder
            ->add('level', EntityType::class, [
                'label' => false,
                'class' => Level::class,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir une difficulté*'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Version::class,
        ]);
    }
}
