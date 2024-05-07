<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'label' => 'Address',
                'attr' => [
                    'class' => 'textaddress',
                    'placeholder' => 'Write Address Here',
                    'required' => true
                ]
            ])
            ->add('method', ChoiceType::class, [
                'label' => 'Payment Method',
                'choices' => [
                    'Select Payment Method' => '',
                    'Credit Card' => 'credit_card',
                    // Add more payment methods if needed
                ],
                'attr' => [
                    'class' => 'box',
                    'required' => true
                ],
                'data' => 'credit_card', // Preselects "Credit Card"
            ])

            ->add('submit', SubmitType::class, [
                'label' => '    Place Order',
                'attr' => [
                    'class' => 'btn order-btn',
                    //'style' => 'background-color: transparent; border: none; color: white; font-size: 25px; cursor: pointer;'


                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
