<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('username', TextType::class,[
                'attr' => ['class' => 'form-control form-control-lg', 'placeholder'=>'Numéro de telephone', 'autocomplete' => 'off'],
                'label' => "Nom utilisateur",
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer un numéro de téléphone"
                    ]),
                    new Regex([
                        'pattern' => '/^\d{10}$/',  // 10 chiffres
                        'message' => 'Le numéro de téléphone doit comporter exactement 10 chiffres.',
                    ])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'attr' => ['class' => 'form-check-input'],
                'label' => "J'ai lu et j'accepte toutes les ",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
//                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control form-control-lg', 'placeholder' => "Votre mot de passe"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options' => ['attr' => ['class' => 'form-control form-control-lg', 'autocomplete' => 'new-password', 'placeholder' => 'Entrez votre mot de passe']],
                'second_options' => ['attr' => ['class' => 'form-control form form-control-lg', 'autocomplete' => 'new-password', 'placeholder' => 'Répétez votre mot de passe']]
            ])

            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Je suis porteur de projet' => "PROJET",
                    'Je cherche un emploi' => "EMPLOI",
                    'Je cherche des contrats' => "RST",
                    'Je cherche des formations' => "FORMATION",
                ],
                'multiple' => false,
                'expanded' => true
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
