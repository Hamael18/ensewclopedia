<?php

namespace App\Form;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class SearchPatternType extends AbstractType
{
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', EntityType::class, [
                'label' => false,
                'required' => true,
                'class' => Brand::class,
                'multiple' => true,
                'query_builder' => function (BrandRepository $br) {
                    return $br->getBrandsOfBrand($this->user);
                },
                'attr' => [
                    'class' => 'selectpicker col-6',
                    'data-live-search' => true,
                    'multiple' => true,
                    'data-none-selected-text' => 'Filtrer par marque',
                ],
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
