<?php

namespace App\Form;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBrandsToUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brands', EntityType::class, [
                'label' => false,
                'class' => Brand::class,
                'multiple' => true,
                'query_builder' => function (BrandRepository $br) {
                    return $br->createQueryBuilder('b')
                        ->where('b.owner IS NULL')
                        ->orderBy('b.name', 'ASC');
                },
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'multiple' => true,
                    'data-none-selected-text' => 'Liste des marques sans propriétaire'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
