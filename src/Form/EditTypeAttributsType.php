<?php


namespace App\Form;


use App\Entity\Collar;
use App\Entity\Fabric;
use App\Entity\Handle;
use App\Entity\Length;
use App\Entity\Size;
use App\Entity\Style;
use App\Entity\Type;
use App\Repository\CollarRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTypeAttributsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $type = $builder->getData();

        /** @var Type $type */
        if ($type->getBoolCollar() == 1) {
            $builder
                ->add('collars', EntityType::class, [
                    'label' => false,
                    'multiple' => true,
                    'class' => Collar::class,
                    'attr' => [
                        'class' => 'selectpicker test-control-search',
                        'multiple' => true,
                        'data-actions-box' => true,
                        'data-none-selected-text' => 'Associer un ou plusieurs cols à ce type'
                    ]
                ])
            ;
        }

        if ($type->getBoolFabric() == 1) {
            $builder
                ->add('fabrics', EntityType::class, [
                    'label' => false,
                    'multiple' => true,
                    'class' => Fabric::class,
                    'attr' => [
                        'class' => 'selectpicker test-control-search',
                        'multiple' => true,
                        'data-actions-box' => true,
                        'data-none-selected-text' => 'Associer un ou plusieurs types de tissus à ce type'
                    ]
                ])
            ;
        }

        if ($type->getBoolHandle() == 1) {
            $builder
                ->add('handles', EntityType::class, [
                    'label' => false,
                    'multiple' => true,
                    'class' => Handle::class,
                    'attr' => [
                        'class' => 'selectpicker test-control-search',
                        'multiple' => true,
                        'data-actions-box' => true,
                        'data-none-selected-text' => 'Associer un ou plusieurs types de manches à ce type'
                    ]
                ])
            ;
        }

        if ($type->getBoolLength() == 1) {
            $builder
                ->add('lengths', EntityType::class, [
                    'label' => false,
                    'multiple' => true,
                    'class' => Length::class,
                    'attr' => [
                        'class' => 'selectpicker test-control-search',
                        'multiple' => true,
                        'data-actions-box' => true,
                        'data-none-selected-text' => 'Associer une ou plusieurs longueurs à ce type'
                    ]
                ])
            ;
        }

        if ($type->getBoolSize() == 1) {
            $builder
                ->add('sizes', EntityType::class, [
                    'label' => false,
                    'multiple' => true,
                    'class' => Size::class,
                    'attr' => [
                        'class' => 'selectpicker test-control-search',
                        'multiple' => true,
                        'data-actions-box' => true,
                        'data-none-selected-text' => 'Associer une ou plusieurs tailles à ce type'
                    ]
                ])
            ;
        }

        if ($type->getBoolStyle() == 1) {
            $builder
                ->add('sizes', EntityType::class, [
                    'label' => false,
                    'multiple' => true,
                    'class' => Style::class,
                    'attr' => [
                        'class' => 'selectpicker test-control-search',
                        'multiple' => true,
                        'data-actions-box' => true,
                        'data-none-selected-text' => 'Associer un ou plusieurs types de style à ce type'
                    ]
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Type::class,
        ]);
    }
}