<?php

namespace App\Form;

use App\Entity\Beneficiaire;
use App\Entity\Entrepreneuriat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EntrepreneuriatFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('code')
            ->add('intitule', TextType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete' => 'off'],
                'label' => "Intitulé du projet *"
            ])
            ->add('objectif', TextareaType::class,[
                'attr' => ['class' => 'form-control'],
                'label' => "Objectif (Pourquoi voulez-vous faire ce projet?) *"
            ])
            ->add('nomEntreprise', TextType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete' => 'off'],
                'label' => "Nom de l'entreprise *"
            ])
            ->add('typeEntreprise', ChoiceType::class,[
                'attr' => ['class' => "form-select"],
                "choices" => [
                    '-- Selectionnez --' => '',
                    'Seul' => "SEUL",
                    'Avec employés' => 'EMPLOYES',
                    'En association' => 'ASSOCIATION'
                ],
                'label' => "Comment voulez-vous travailler? *"
            ])
            ->add('adresse', TextType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete' => 'off'],
                'label' => "A quel endroit serez-vous situé? *"
            ])
            ->add('produitPropose', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Quels produits / services proposez-vous?",
                'required' =>  false
            ])
            ->add('force', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Quelles sont les forces?",
                'required' => false
            ])
            ->add('matierePremiere', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Quels vos produits et matières premières?",
                'required' => false
            ])
            ->add('lieuMatierePremiere', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Où allez-vous acheter vos produits et matières premières?",
                'required' => false
            ])
            ->add('clientActuel', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Qui sont les clients actuels?",
                'required' => false
            ])
            ->add('clientFutur', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Qui sont les clients futurs? *"
            ])
            ->add('concurrent', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Qui sont les concurrents",
                'required' => false
            ])
            ->add('prixProduit', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Quel est le prix de vos produits?",
                'required' => false
            ])
            ->add('beneficeProduit', TextareaType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Quel est le benefice défini par produit?",
                'required' => false
            ])
            ->add('fixeProduit', TextType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Comment fixez-vous le prix? *"
            ])
            ->add('modePaiement', ChoiceType::class,[
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    '-- Selectionnz --' => '',
                    'Cash' => 'CASH',
                    'Crédit' => 'CREDIT'
                ],
                'label' => "Condition de paiement *"
            ])
            ->add('modeVente', ChoiceType::class,[
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    '-- SELECTIONNEZ --' => '',
                    'Direct' => 'DIRECT',
                    'Avec des distributeurs' => 'DISTRIBUTEUR',
                    'Détaillants' => 'DETAILLANTS'
                ],
                'label' => "Comment allez-vous vendre vos produits? *"
            ])
            ->add('promotion', ChoiceType::class,[
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    '-- Selectionnez --' => '',
                    "Bouche à l'oreille" => 'BOUCHE',
                    "Petite rencontre" => 'RENCONTRE',
                    "A la criée" => 'CRIEE'
                ],
                'label' => "Comment voulez-vous faire connaitre?",
                'required' => false
            ])
            ->add('nomAval', TextType::class,[
                'attr' => ['class' => "form-control", 'autocomplete' => 'off'],
                'label' => "Nom & prenoms de l'aval *"
            ])
            ->add('dateNaissanceAval', DateType::class,[
                'attr' => ['class' => "form-control", 'autocomplete' => 'off'],
                'label' => "Date de naissance de l'aval *"
            ])
            ->add('lieuNaissanceAval', TextType::class,[
                'attr' => ['class' => "form-control", 'autocomplete' => 'off'],
                'label' => "Lieu de naissance de l'Aval *"
            ])
            ->add('residenceAval', TextType::class,[
                'attr' => ['class' => "form-control", 'autocomplete' => 'off'],
                'label' => "Résidence habituelle de l'aval *"
            ])
            ->add('professionAval', TextType::class,[
                'attr' => ['class' => "form-control", 'autocomplete' => 'off'],
                'label' => "Profession de l'aval *"
            ])
            ->add('telephoneAval', TelType::class,[
                'attr' => ['class' => "form-control", 'autocomplete' => 'off'],
                'label' => "Téléphone de l'aval *"
            ])
            ->add('emailAval', EmailType::class,[
                'attr' => ['class' => "form-control", 'autocomplete' => 'off'],
                'label' => "Email de l'aval *"
            ])
            ->add('media', FileType::class,[
                'attr'=>['class'=>"form-control"],
                'label' => "Téléchargez la copie de la pièce d'identité de l'Aval *",
                'mapped' => false,
                'multiple' => false,
                'constraints' => [
                    new File([
                        'maxSize' => "600000k",
                        'mimeTypes' =>[
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => "Votre fichier doit être de type image ou document PDF",
                        //'maxSizeMessage' => "La taille de votre image doit être inférieure à 2Mo",
                    ])
                ],
                'required' => false
            ])
            ->add('montantChiffre', IntegerType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>"off"],
                'label' => "Montant en chiffre *"
            ])
            ->add('montantLettre', TextType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>'off'],
                'label' => "Montant en lettre *"
            ])
            ->add('modeRemboursement', ChoiceType::class,[
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    '-- Selectionnez --' => '',
                    'Par semaine' => "SEMAINE",
                    'Par mois' => 'MOIS',
                    'Par trimestre' => 'TRIMESTRE',
                    'Par semestre' => 'SEMESTRE',
                    'Autre' => 'AUTRE'
                ],
                'label' => "Fréquence",
                'required' => false
            ])
            ->add('autreMode', TextType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete'=>'off'],
                'label' => "Autre fréquence de remboursement",
                'required' => false
            ])
//            ->add('statut')
//            ->add('createdAt', null, [
//                'widget' => 'single_text',
//            ])
//            ->add('updateAt', null, [
//                'widget' => 'single_text',
//            ])
//            ->add('slug')
//            ->add('beneficiaire', EntityType::class, [
//                'class' => Beneficiaire::class,
//                'choice_label' => 'id',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrepreneuriat::class,
        ]);
    }
}
