<?php

namespace App\Form;

use App\Entity\Weight;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\GreaterThan;


class WeightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Weight', NumberType::class, [ 
            'attr' => [
                'class' => 'Weight',
                'style' => 'margin: 15px 20px 5px 5px'
            ],
            'constraints' => [
                new GreaterThan(0),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Weight::class,
        ]);
    }
}
