<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Validator\Constraints\NoBlankOrSpace;
use App\Validator\Constraints\NotBlankOrSpaceValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email',null,['disabled' => true])
            ->add('old_password', PasswordType::class, [
            'mapped' => false,
            'required' => false,
        ])
            ->add('new_password', PasswordType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('num_tel')
            ->add('image', FileType::class, [
                'label' => 'Your Profile Image (Image file only)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image .jpeg, .png, .gif file only',
                    ])
                ],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Update Your Profile'
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
