<?php

namespace App\Form;

use App\Entity\Sku;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThan;

class SkuType extends AbstractType
{
    public function classMethods(): array
    {
        $sku = new Sku();
        $sku = $sku->classMethodsGet();
        return $sku;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Sku', IntegerType::class, [
            'attr' => [
                'class' => 'Sku',
                'style' => 'margin: 15px 0 5px 5px'
            ], 
            'constraints' => [
                new NotBlank(),
                new GreaterThan(0),
            ],
        ]);
        // Need to create a formType of entities
        foreach($this->classMethods() as $array) {
            foreach($array as $getProperty) {
                if (preg_match('/getSku/', $getProperty)) {
                    continue;
                }
                $property = preg_replace('/^get/', '', $getProperty);
                $formType = "App\Form\\$property"."Type"::class;

                $builder->add($property, $formType, ['label' => false, 'required' => false,]);
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sku::class,
        ]);
    }
}
