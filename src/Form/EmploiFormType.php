<?php

namespace App\Form;

use App\Entity\Beneficiaire;
use App\Entity\Emploi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmploiFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contrat', ChoiceType::class,[
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    '-- Selectionnez --' => '',
                    'CDI' => 'CDI',
                    'CDD' => 'CDD',
                    'Stage' => 'STAGE',
                    'Apprentissage' => 'APPRENTISSAGE',
                    'Autre' => 'AUTRE'
                ]
            ])
            ->add('entreprise', TextType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete' => 'off'],
                'label' => "Nom de l'entreprise *"
            ])
            ->add('salaire', IntegerType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete' => 'off'],
                'label' => "Salaire",
                'required' => false
            ])
            ->add('duree', TextType::class,[
                'attr' => ['class' => 'form-control', 'autocomplete' => 'off'],
                'label' => "Durée de l'emploi",
                'required' => false
            ])
            ->add('commencement', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'label' => "Date de commencement *"
            ])
//            ->add('createdAt', null, [
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
            'data_class' => Emploi::class,
        ]);
    }
}
