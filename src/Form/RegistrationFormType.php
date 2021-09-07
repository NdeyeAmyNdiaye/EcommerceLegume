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
use Webmozart\Assert\Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                'label' => 'Votre prénom',
                'attr' =>[
                    'placeholder' => 'Merci de saisir votre prénom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => ' Ce champ ne peut pas être vide ,merci de saisir votre prénom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit avoir au moins 2 caractéres',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                    ]),
                    new Regex([
                        'pattern' => '/\d/',
                        'match' => false,
                        'message' => 'Votre prénom ne peut pas contenir des chiffres',
                    ])
                 ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Votre nom',
                'attr' =>[
                    'placeholder' => 'Merci de saisir votre nom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => ' Ce champ ne peut pas être vide ,merci de saisir votre nom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit avoir au moins 2 caractéres',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                    ]),
                    new Regex([
                        'pattern' => '/\d/',
                        'match' => false,
                        'message' => 'Votre nom ne peut pas contenir des chiffres',
                    ])
                 ]
            ])
            ->add('email',EmailType::class,[
                'label' => 'Votre email',
                'attr' =>[
                    'placeholder' => 'Merci de saisir votre email'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'first_options'  => ['label' => 'Votre mot de passe',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre mot de passe'    
                ]],
                 'second_options' => ['label' => 'Confirmer votre mot de passe',
                 'attr' => [
                    'placeholder' => 'Merci de confirmer votre mot de passe'    
                ]],
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'autocomplete' => 'new-password',   
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit avoir au moins 6 caractéres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
