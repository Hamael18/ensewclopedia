<?php

namespace App\Form;

use App\Entity\Collar;
use App\Entity\Fabric;
use App\Entity\Handle;
use App\Entity\Length;
use App\Entity\Size;
use App\Entity\Style;
use App\Repository\LevelRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltresTypesType extends AbstractType
{
    private $type;
    private $levels;

    public function __construct(RequestStack $request, LevelRepository $levelRepository)
    {
        $this->type = $request->getCurrentRequest()->attributes->get('type');
        $this->levels = $levelRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->type->getBoolLevel() == 1) {
            $choices = [];
            foreach ($this->levels->findAll() as $level) {
                $choices[$level->getName()] = $level->getName();
            }
            $builder
                ->add('levels', ChoiceType::class, [
                    'choices' => $choices,
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'selectpicker col-1',
                        'multiple' => true,
                        'data-none-selected-text' => 'Choix',
                    ]
                ]);
        }
        ;
        if ($this->type->getBoolLength() == 1) {
            $choices = [];
            foreach ($this->type->getLengths() as $length) {
                /** @var Length $length */
                $choices[$length->getName()] = $length->getName();
            }
            $builder
                ->add('lengths', ChoiceType::class, [
                    'choices' => $choices,
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'selectpicker col-2',
                        'multiple' => true,
                        'data-none-selected-text' => 'Choix',
                    ]
                ]);
        }
        if ($this->type->getBoolHandle() == 1) {
            $choices = [];
            foreach ($this->type->getHandles() as $handle) {
                /** @var Handle $handle */
                $choices[$handle->getName()] = $handle->getName();
            }
            $builder
                ->add('handles', ChoiceType::class, [
                    'choices' => $choices,
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'selectpicker col-2',
                        'multiple' => true,
                        'data-none-selected-text' => 'Choix',
                    ]
                ]);
        }
        if ($this->type->getBoolSize() == 1) {
            $choices = [];
            foreach ($this->type->getSizes() as $size) {
                /** @var Size $size */
                $choices[$size->getLibelle()] = $size->getLibelle();
            }
            $builder
                ->add('sizes', ChoiceType::class, [
                    'choices' => $choices,
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'selectpicker col-2',
                        'multiple' => true,
                        'data-none-selected-text' => 'Choix',
                    ]
                ]);
        }
        if ($this->type->getBoolCollar() == 1) {
            $choices = [];
            foreach ($this->type->getCollars() as $collar) {
                /** @var Collar $collar */
                $choices[$collar->getName()] = $collar->getName();
            }
            $builder
                ->add('collars', ChoiceType::class, [
                    'choices' => $choices,
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'selectpicker col-2',
                        'multiple' => true,
                        'data-none-selected-text' => 'Choix',
                    ]
                ]);
        }
        if ($this->type->getBoolFabric() == 1) {
            $choices = [];
            foreach ($this->type->getFabrics() as $fabric) {
                /** @var Fabric $fabric */
                $choices[$fabric->getName()] = $fabric->getName();
            }
            $builder
                ->add('fabrics', ChoiceType::class, [
                    'choices' => $choices,
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'selectpicker col-1',
                        'multiple' => true,
                        'data-none-selected-text' => 'Choix',
                    ]
                ]);
        }
        if ($this->type->getBoolStyle() == 1) {
            $choices = [];
            foreach ($this->type->getStyles() as $style) {
                /** @var Style $style */
                $choices[$style->getName()] = $style->getName();
            }
            $builder
                ->add('styles', ChoiceType::class, [
                    'choices' => $choices,
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'selectpicker col-2',
                        'multiple' => true,
                        'data-none-selected-text' => 'Choix',
                    ]
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
