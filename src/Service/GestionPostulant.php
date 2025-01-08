<?php

namespace App\Service;

use App\Entity\Beneficiaire;
use App\Entity\Tampon;
use App\Entity\User;
use App\Service\GestionMedia;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GestionPostulant
{
    CONST STATUT_SELCTIONNER = 'SELECTIONNER';
    CONST STATUT_BENEFICIAIRE = 'BENEFICIAIRE';
    CONST STATUT_POSTULANT = 'POSTULANT';
    CONST CLASSE_EMPLOI = 'EMPLOI';
    CONST CLASSE_FORMATION = 'FORMATION';
    CONST CLASSE_ENTREPRENEURIAT = 'ENTREPRENEURIAT';
    CONST CLASSE_RST = 'RST';

    public function __construct(private readonly Utilities $utilities, private readonly GestionMedia $gestionMedia, private readonly EntityManagerInterface $entityManager, private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function valideUniquePostulant(Beneficiaire $postulant): bool
    {
        // Vérification du numero de telephone
        if (!$this->utilities->uniciteUser($postulant)){
            sweetalert()->error("Le numero de telephone est déjà utilisé dans le système", [], 'Echèc');
            return false;
        }

        // Vérification de l'unicité du postulant
        if (!$this->utilities->unicitePostulant($postulant)) {
            sweetalert()->error("Ce postulant a déjà été enregistré", [], 'Échec');
            return false;
        }

        return true;
    }

    public function processPostulantData(Beneficiaire $postulant, Request $requestStack, $form): void
    {
        $objectif = $requestStack->request->get('beneficiaire_form_objectif');

        // Gestion des medias
        $this->gestionMedia->media($form, $postulant, 'profile');

        // Definition des valeurs du postulant
        $postulant->setMatricule($this->utilities->matricule());
        $postulant->setClasse($objectif);

        // Création d'un utilisateur associé
        $code = $this->utilities->uniciteUser($postulant);
        $user = $this->createUserForPostulant($postulant, $objectif, $code);
        $postulant->setUser($user);

        // Création d'un tampon associé
        $tampon = $this->createTamponForPostulant($postulant, $code);

        // Persister les enregistrement
        $this->entityManager->persist($postulant);
        $this->entityManager->persist($user);
        $this->entityManager->persist($tampon);
        $this->entityManager->flush();
    }

    public function createUserForPostulant(Beneficiaire $postulant, string $objectif, $code): User
    {
        $user = new User();
        $user->setUsername($postulant->getTelephone());
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                strtolower($postulant->getNom()) . $code
            )
        );
        $user->setStatut($objectif);

        return $user;
    }

    public function createTamponForPostulant(Beneficiaire $postulant, $code): Tampon
    {
        $tampon = new Tampon();
        $tampon->setName($postulant->getTelephone());
        $tampon->setWord($this->utilities->transformMot($postulant->getNom()));
        $tampon->setCode($code);

        return $tampon;
    }
}