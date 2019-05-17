<?php

namespace App\Form;

use App\Entity\Attack;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('is_cs')
            ->add('type')
            ->add('accuracy')
            ->add('power')
            ->add('ct')
            ->add('name')
            ->add('code')
            ->add('description')
            ->add('powerPoints')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Attack::class,
        ]);
    }
}