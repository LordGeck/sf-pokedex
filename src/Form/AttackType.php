<?php

namespace App\Form;

use App\Entity\Attack;
use App\Enum\TypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Utils;

class AttackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $availableTypes = TypeEnum::getAvailableTypes();
        $availableTypes = array_diff($availableTypes, array(null));
        
        $builder
            ->add('is_cs')
            ->add('type', ChoiceType::class, [
                'required' => true,
                'choices' => $availableTypes,
                'choice_label' => function($choice) {
                    return TypeEnum::getTypeName($choice);
                },
            ])
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
            'translation_domain' => 'forms'
        ]);
    }
}
