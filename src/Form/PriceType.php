<?php

namespace App\Form;

use App\Entity\Price;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\GreaterThan;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Price', NumberType::class, [ 
            'attr' => [
                'class' => 'Price',
                'style' => 'margin: 15px 7px 5px 5px'
            ],
            'constraints' => [
                new GreaterThan(0),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Price::class,
        ]);
    }
}
