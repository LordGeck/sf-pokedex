<?php

namespace App\Form;

use App\Entity\Pokemon;
use Symfony\Component\Form\AbstractType;
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
            ->add('type1')
            ->add('type2')
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
        ]);
    }
}
