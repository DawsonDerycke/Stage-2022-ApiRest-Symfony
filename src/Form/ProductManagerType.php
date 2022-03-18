<?php

namespace App\Form;

use App\Entity\ProductManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;

class ProductManagerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('ProductManager', TextType::class, [ 
            'attr' => [
                'class' => 'ProductManager',
                'style' => 'margin: 15px 92px 5px 5px;'
            ], 
            'constraints' => [
                new Length([
                    'max' => 100, 
                    'maxMessage' => 'This value should be less than 100 characters.'
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductManager::class,
        ]);
    }
}
