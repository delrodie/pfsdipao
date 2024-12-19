<?php

namespace App\Form;

use App\Entity\Beneficiaire;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class BeneficiaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('matricule')
            ->add('nom', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder'=>"", 'autocomplete'=>"off"],
                'label' => "Nom de famille"
            ])
            ->add('prenom', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder'=>"", 'autocomplete'=>"off"],
                'label' => "Prenoms"
            ])
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'label' => "Date de naissance"
            ])
            ->add('lieuNaissance', TextType::class,[
                'attr' =>['class' => "form-control", 'placeholder'=>"", 'autocomplete'=>'off'],
                'label' => "Lieu de naissance"
            ])
            ->add('sexe', ChoiceType::class,[
                'attr' => ['class' => "form-select"],
                'choices' => [
                    '-- Selectionnez --' => "",
                    'Homme' => "HOMME",
                    'Femme' => "FEMME"
                ]
            ])
            ->add('nationalite', TextType::class,[
                'attr' =>['class' => "form-control", 'placeholder'=>"", 'autocomplete'=>'off'],
                'label' => "Nationalité"
            ])
            ->add('region', TextType::class,[
                'attr' =>['class' => "form-control", 'placeholder'=>"", 'autocomplete'=>'off'],
                'label' => "Région d'origine"
            ])
            ->add('telephone', TextType::class,[
                'attr' =>['class' => "form-control", 'placeholder'=>"", 'autocomplete'=>'off'],
                'label' => "Téléphone",
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
            ->add('adresse', TextType::class,[
                'attr' =>['class' => "form-control", 'placeholder'=>"", 'autocomplete'=>'off'],
                'label' => "Lieu de résidence habituel"
            ])
            ->add('natureCNI', ChoiceType::class,[
                'attr' => ['class' => 'form-control'],
                'choices' =>[
                    '-- Selectionnez --' => '',
                    'CNI-ORANGE' => 'CNI-ORANGE',
                    'CNI-VERTE' => 'CNI-VERTE',
                    "ATTESTATION D'IDENTITE"  => "ATTESTATION D'IDENTITE",
                    "PASSEPORT"  => "PASSEPORT",
                    "AUTRE"  => "AUTRE",
                ],
                'label' => "Nature de votre carte d'identité"
            ])
            ->add('numeroCNI', TextType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete' => 'off' ],
                'label' => "Nunméro de votre carte d'identité"
            ])
            ->add('media', FileType::class,[
                'attr'=>['class'=>"dropify-fr", 'data-preview' => ".preview"],
                'label' => "Téléchargez votre photo de profile",
                'mapped' => false,
                'multiple' => false,
                'constraints' => [
                    new File([
                        'maxSize' => "20000k",
                        'mimeTypes' =>[
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/webp',
                        ],
                        //'mimeTypesMessage' => "Votre fichier doit être de type image",
                        //'maxSizeMessage' => "La taille de votre image doit être inférieure à 2Mo",
                    ])
                ],
                'required' => false
            ])
            ->add('enfantFamille', IntegerType::class,[
                'attr' =>['class' => "form-control", 'autocomplete'=>'off'],
                'label'=> "Nombre d'enfants dans la famille"
            ])
            ->add('enfantCharge', IntegerType::class,[
                'attr' =>['class' => "form-control", 'autocomplete'=>'off'],
                'label'=> "Nombre d'enfants à charge"
            ])
            ->add('matrimoniale', ChoiceType::class,[
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    '-- Selectionnez --' => "",
                    "Célibataire" => "CELIBATAIRE",
                    "Marié(e)" => "MARIE(E)",
                    "Concubinage" => "CONCUBINAGE",
                    "Divorcé(e)" => "DIVORCE(E)",
                    "Veuf(ve)" => "VEUF(VE)"
                ],
                'label' => "Situation matrimoniale"
            ])
            ->add('hebergement', ChoiceType::class,[
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    '-- Selectionnez --' => "",
                    " Chez moi" => "CHEZ MOI",
                    "Chez mes parents" => "CHEZ MES PARENTS",
                    "Chez mes amis" => "CHEZ MES AMIS",
                    "AUTRE" => "AUTRES"
                ],
                'label' => "Hebergement"
            ])
            ->add('typeRessource', ChoiceType::class,[
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    "-- Selectionnez --" => "",
                    "Père" => "PERE",
                    "Mère" => "MERE",
                    'Tuteur/tutrice' => "TUTEUR/TUTRICE",
                    'Conjoint(e)' => "CONJOINT(E)"
                ],
                'label' => "Personne ressource"
            ])
            ->add('nomRessource', TextType::class,[
                'attr'=>['class' => "form-control", 'autocomplete'=>"off"],
                'label' => "Nom & prenoms de la personne ressource"
            ])
            ->add('telephoneRessource', TextType::class,[
                'attr'=>['class' => "form-control", 'autocomplete'=>"off"],
                'label' => "Téléphone de la personne ressource"
            ])
            ->add('adresseRessource', TextType::class,[
                'attr'=>['class' => "form-control", 'autocomplete'=>"off"],
                'label' => "Adresse de la personne ressource"
            ])
            ->add('analphabete', ChoiceType::class,[
                'attr' => ['class' => 'form-control'],
                'choices' =>[
                    'OUI' => 1,
                    'NON' => 0
                ],
                'label' => "Analphabète"
            ])
            ->add('niveauEtude', TextType::class,[
                'attr'=>['class' => "form-control", 'autocomplete'=>"off"],
                'label' => "Niveau d'étude"
            ])
            ->add('diplome', ChoiceType::class,[
                'attr' => ['class' => 'form-control'],
                'choices' =>[
                    ' -- Selectionnez --' => "",
                    'CEPE' => "CEPE",
                    'BEPC' => 'BEPC',
                    'CAP' => 'CAP',
                    'BAC' => "BAC",
                    'BT' => "BT",
                    'BTS' => 'BTS',
                    'Licence' => 'LICENCE',
                    'Ingénieur' => "INGENIEUR",
                    'Maitrise' => "MAITRISE",
                    'Autre' => "AUTRE"
                ]
            ])
            ->add('niveauFormation', TextType::class,[
                'attr'=>['class' => "form-control", 'autocomplete'=>"off"],
                'label' => "Niveau de formation professionnelle",
                'required' => false
            ])
            ->add('natureFormation', TextType::class,[
                'attr'=>['class' => "form-control", 'autocomplete'=>"off"],
                'label' => "Nature de formation professionnelle",
                'required' => false
            ])
//            ->add('slug')
//            ->add('user', EntityType::class, [
//                'class' => User::class,
//                'choice_label' => 'id',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Beneficiaire::class,
        ]);
    }
}
