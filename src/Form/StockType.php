<?php

namespace App\Form;

use App\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;


class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Stock', IntegerType::class, [ 
            'attr' => [
                'class' => 'Stock',
                'style' => 'margin: 15px 10px 5px 5px'
            ],
            'constraints' => [
                new GreaterThanOrEqual(0),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
