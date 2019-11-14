<?php

namespace App\Form;

use App\Repository\RoleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class SearchUserType extends AbstractType
{
    private $repo;

    public function __construct(RoleRepository $repository)
    {
        $this->repo = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'multiple' => true,
                'choices' => [
                    'Admin' => $this->repo->findOneBy(['libelle' => 'ROLE_ADMIN'])->getId(),
                    'Marque' => $this->repo->findOneBy(['libelle' => 'ROLE_MARQUE'])->getId(),
                    'User' => null
                ],
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Email'],
                'constraints' => [new Length(['min' => 3])],
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
