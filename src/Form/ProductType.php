<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, [
                'data' => 1, // default value
            ])
            ->add('quantity', IntegerType::class, // Change the input type to IntegerType
                [
                    'label' => false,
                    'data' => 1, // default value
                    'attr' => [
                        'class'=> 'qty',
                        'min' => 1,
                        'max' => 99
                    ]
                ])

            ->add('submit', SubmitType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'fas fa-shopping-cart',

                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}
