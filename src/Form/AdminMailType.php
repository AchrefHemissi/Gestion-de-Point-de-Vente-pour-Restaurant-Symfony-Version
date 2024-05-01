<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('recipient', EmailType::class, [
                'label' => 'Recipient:',
                'required' => true,
            ])
            ->add('subject', TextType::class, [
                'label' => 'Subject:',
                'required' => true,
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message:',
                'required' => true,
                'attr' => ['rows' => 6],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Send Email',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}
