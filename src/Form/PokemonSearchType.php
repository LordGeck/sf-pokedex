<?php

namespace App\Form;

use App\Entity\PokemonSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Enum\TypeEnum;

class PokemonSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // build correct set of label => value for choice fields
        $typeChoices = [];
        $typeLabels = TypeEnum::getTypeLabels();
        $availableTypes = TypeEnum::getAvailableTypes(false);
        for($i=0; $i<sizeof($typeLabels); $i++)
        {
            $typeChoices[$typeLabels[$i]] = $availableTypes[$i];
        }

        $builder
            ->add('name', TextareaType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom du pokémon'
                ]
            ])
            ->add('type1', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Sélectionnez type 1'
                ],
                'choices' => $typeChoices
            ])
            ->add('type2', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type 2 du pokémon'
                ],
                'choices' => $typeChoices
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PokemonSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
