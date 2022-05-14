<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
                'label' => false,
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre prénom doit contenir au moins trois caractères'
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom',
                ],
                'label' => false,
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre prénom doit contenir au moins trois caractères'
                    ])
                ]
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'Pseudo'
                ],
                'label' => false,
                'trim' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre prénom doit contenir au moins trois caractères'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'votre@email.com'],
                'label' => false,
                'trim' => true
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'En soumettant ce formulaire, vous acceptez le traitement des données collectées',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter notre politique de confidentialité',
                    ]),
                ],
                'attr' => [
                    'class' => 'checkbox__rgpd'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Saisissez votre mot de passe',
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Confirmez votre mot de passe',

                    ]
                ],
                'invalid_message' => 'Les mots de passe saisis ne sont pas identiques',
                'required' => true,
                'trim' =>true,
                'mapped' => false,

                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                         'minMessage' => 'Votre mot de passe doit contenir {{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '#^(?=(.*[A-Z])+)(?=(.*[a-z])+)(?=(.*[\d])+)(?=.*\W)(?!.*\s).{8,100}$#',
                        'htmlPattern' => '^(?=(.*[A-Z])+)(?=(.*[a-z])+)(?=(.*[\d])+)(?=.*\W)(?!.*\s).{8,100}$',
                        'message' => 'Votre mot de passe doit contenir 8 caractères minimum dont une majuscule, un chiffre et un caractère spécial'
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
