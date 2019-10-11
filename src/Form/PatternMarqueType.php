<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Gender;
use App\Entity\Language;
use App\Entity\Pattern;
use App\Repository\BrandRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class PatternMarqueType extends AbstractType
{
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nom du patron']
            ])
            ->add('price', MoneyType::class, [
                'label' => false
            ])
            ->add('description', CKEditorType::class, [
                'label' => false,
                'config_name' => 'config_custom'
            ])
            ->add('lien', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Lien']
            ])
            ->add('brand', EntityType::class, [
                'label' => false,
                'class' => Brand::class,
                'query_builder' => function (BrandRepository $repo) {
                    return $repo->createQueryBuilder('b')
                        ->andWhere('b.owner = :user')
                        ->setParameter('user', $this->user)
                    ;
                },
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-none-selected-text' => 'Choisir une marque'
                ]
            ])
            ->add('languages', EntityType::class, [
                'label' => false,
                'class' => Language::class,
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'multiple' => true,
                    'data-none-selected-text' => 'Choisir une ou plusieurs langue(s)'
                ]
            ])
            ->add('genres', EntityType::class, [
                'label' => false,
                'class' => Gender::class,
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'multiple' => true,
                    'data-none-selected-text' => 'Choisir un ou plusieurs genre(s)'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pattern::class,
        ]);
    }
}