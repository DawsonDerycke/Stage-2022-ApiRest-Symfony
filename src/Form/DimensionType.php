<?php

namespace App\Form;

use App\Entity\Dimension;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;


class DimensionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Dimension', TextType::class, [ 
            'attr' => [
                'class' => 'Dimension',
                'style' => 'margin: 15px 50px 5px 5px;'
            ], 
            'constraints' => [
                new Length([
                    'min' => 3, 'max' => 100, 
                    'minMessage' => 'This value should be between 3 and 100 characters.',
                    'maxMessage' => 'This value should be between 3 and 100 characters.'
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dimension::class,
        ]);
    }
}
