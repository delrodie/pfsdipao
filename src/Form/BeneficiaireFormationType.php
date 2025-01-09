<?php

namespace App\Form;

use App\Entity\Beneficiaire;
use App\Entity\Diplome;
use App\Entity\Formation;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BeneficiaireFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('structure', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder'=>"", 'autocomplete'=>"off"],
                'label' => "Nom de la structure ou établissement *"
            ])
            ->add('duree', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder'=>"", 'autocomplete'=>"off"],
                'label' => "Durée de la formation *"
            ])
            ->add('commencement', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'label' => "Date début de la formation *"
            ])
//            ->add('beneficiaire', EntityType::class, [
//                'class' => Beneficiaire::class,
//                'choice_label' => 'id',
//            ])
            ->add('specialisation', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'titre',
                'attr' => ['class' => 'form-select select-2'],
                'label' => 'Spécialisation *'
            ])
            ->add('diplome', EntityType::class, [
                'class' => Diplome::class,
                'choice_label' => 'titre',
                'attr' => ['class' => 'form-select'],
                'label' => 'Diplome ou certification *'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
