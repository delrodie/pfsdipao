<?php

namespace App\Service;

use App\Repository\BeneficiaireRepository;
use App\Repository\CuriculumRepository;
use App\Repository\DiplomeRepository;
use App\Repository\EmploiRepository;
use App\Repository\EntrepreunariatRepository;
use App\Repository\FormationProfessionnelleRepository;
use App\Repository\FormationRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\SpecialiteRepository;
use App\Repository\TamponRepository;
use App\Repository\UserRepository;

class AllRepositories
{
    public function __construct(
        private BeneficiaireRepository             $beneficiaireRepository,
        private CuriculumRepository                $curiculumRepository,
        private NiveauEtudeRepository              $etudeRepository,
        private readonly DiplomeRepository         $diplomeRepository,
        private SpecialiteRepository               $specialiteRepository,
        private FormationProfessionnelleRepository $formationProfessionnelleRepository,
        private EntrepreunariatRepository          $entrepreunariatRepository,
        private readonly UserRepository            $userRepository,
        private TamponRepository                   $tamponRepository,
        private EmploiRepository                   $emploiRepository,
        private FormationRepository                $formationRepository,
    )
    {
    }

    // BENEFICIAIRE
    public function getOneBeneficiaire(string $matricule = null, object $user = null, string $slug = null)
    {
        if ($matricule){
            return $this->beneficiaireRepository->findOneBy(['matricule' => $matricule]);
        }

        if ($user){
            return $this->beneficiaireRepository->findOneBy(['user' => $user]);
        }

        if ($slug){
            return $this->beneficiaireRepository->findOneBy(['slug' => $slug]);
        }

        return $this->beneficiaireRepository->findOneBy([],['id' => 'DESC']);
    }

    public function getOneCV(object $user)
    {
        return $this->curiculumRepository->findOneBy(['user' => $user]);
    }

    public function getAllBeneficiaireByStatutAndClasse(string $statut = null, string $statut2 = null, string $classe = null)
    {
        return $this->beneficiaireRepository->findByStatutAndClasse($statut, $statut2, $classe);
    }

    public function getOneNiveauEtude(string $slug)
    {
        return $this->etudeRepository->findOneBy(['slug' => $slug]);
    }

    public function getOneDiplome(string $slug)
    {
        return $this->diplomeRepository->findOneBy(['slug' => $slug]);
    }

    public function getOneSpecialite(string $slug)
    {
        return $this->specialiteRepository->findOneBy(['slug' => $slug]);
    }

    public function getOneFormationProfessionelle(string $slug)
    {
        return $this->formationProfessionnelleRepository->findOneBy(['slug' => $slug]);
    }

    public function getOneEntrepreneuriat(string $slug = null, string $code = null)
    {
        if ($slug) {
            return $this->entrepreunariatRepository->findOneBy(['slug' => $slug]);
        }

        if ($code){
            return $this->entrepreunariatRepository->findOneBy(['code' => $code]);
        }

        return $this->entrepreunariatRepository->findOneBy([],['id' => 'DESC']);
    }

    public function getAllEntrepreneuriat()
    {
        return $this->entrepreunariatRepository->findAll();
    }

    public function getAllPostulant(string $statut = null)
    {
        return $this->beneficiaireRepository->findPostulant($statut);
    }

    public function findOneUser($getTelephone)
    {
        return $this->userRepository->findOneBy(['username' => $getTelephone]);
    }

    public function getTampon(?string $getTelephone)
    {
        return $this->tamponRepository->findOneBy(['name' => $getTelephone]);
    }

    public function getOneUser(?string $username)
    {
        return $this->userRepository->findOneBy(['username' => $username]);
    }

    public function getOneEmploi(string $slug)
    {
        return $this->emploiRepository->findOneBy(['slug' => $slug]);
    }

    public function getAllEmploiByBeneficiaire($beneficiaire)
    {
        return $this->emploiRepository->findBy(['beneficiaire' => $beneficiaire], ['commencement' => 'DESC']);
    }

    public function getAllEntrepriseByBeneficiaire($beneficiaire)
    {
        return $this->entrepreunariatRepository->findBy(['beneficiaire' => $beneficiaire], ['createdAt' => 'DESC']);
    }

    public function getAllEntreprises()
    {
        return $this->entrepreunariatRepository->findAllEntreprises();
    }

    public function getAllEntrepriseByStatut(string $finance = null)
    {
        return $this->entrepreunariatRepository->findByStatut($finance);
    }

    public function getOneFormation(string $slug)
    {
        return $this->formationRepository->findOneBy(['slug' => $slug]);
    }

    public function getAllFormationByBeneficiaire($beneficiaire)
    {
        return $this->formationRepository->findByBeneficiaire($beneficiaire);
    }

    public function getAllInseres()
    {
        return $this->beneficiaireRepository->findByStatut(GestionPostulant::STATUT_BENEFICIAIRE);
    }

    // STATISTIQUES

    public function getBeneficiaireByStatutAndClasse(string $statut = null, string $classe = null)
    {
        return $this->beneficiaireRepository->findByOneStatutAndClasse($statut, $classe);
    }
    public function getBeneficiaireByStatutClasseAndSexe(string $statut = null, string $classe = null, string $sexe = null)
    {
        return $this->beneficiaireRepository->findByOneStatutClasseAndSexe($statut, $classe, $sexe);
    }

    public function getTotalFinance()
    {
        return $this->entrepreunariatRepository->findTotalFinance();
    }
}