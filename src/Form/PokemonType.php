<?php

namespace App\Form;

use App\Entity\Pokemon;
use App\Enum\TypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('no_pokedex')
            ->add('hp')
            ->add('atk')
            ->add('def')
            ->add('spe')
            ->add('speed')
            ->add('location')
            ->add('image')
            ->add('type1', ChoiceType::class, [
                'required' => true,
                'choices' => TypeEnum::getAvailableTypes(),
                'choice_label' => function($choice) {
                    return TypeEnum::getTypeName($choice);
                },
            ])
            ->add('type2', ChoiceType::class, [
                'required' => true,
                'choices' => TypeEnum::getAvailableTypes(),
                'choice_label' => function($choice) {
                    return TypeEnum::getTypeName($choice);
                },
            ])
            ->add('size')
            ->add('weight')
            ->add('name')
            ->add('nature')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
            'translation_domain' => 'forms'
        ]);
    }   
}
