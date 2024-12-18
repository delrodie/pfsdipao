<?php

namespace App\Form;

use App\Entity\Beneficiaire;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BeneficiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule')
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('lieuNaissance')
            ->add('sexe')
            ->add('nationalite')
            ->add('region')
            ->add('telephone')
            ->add('adresse')
            ->add('media')
            ->add('enfantFamille')
            ->add('enfantCharge')
            ->add('matrimoniale')
            ->add('hebergement')
            ->add('typeRessource')
            ->add('nomRessource')
            ->add('telephoneRessource')
            ->add('adresseRessource')
            ->add('analphabete')
            ->add('niveauEtude')
            ->add('diplome')
            ->add('niveauFormation')
            ->add('natureFormation')
            ->add('slug')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Beneficiaire::class,
        ]);
    }
}
