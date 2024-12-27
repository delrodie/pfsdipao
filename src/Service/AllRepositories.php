<?php

namespace App\Service;

use App\Repository\BeneficiaireRepository;
use App\Repository\CuriculumRepository;
use App\Repository\DiplomeRepository;
use App\Repository\EntrepreunariatRepository;
use App\Repository\FormationProfessionnelleRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\SpecialiteRepository;

class AllRepositories
{
    public function __construct(
        private BeneficiaireRepository $beneficiaireRepository,
        private CuriculumRepository $curiculumRepository,
        private NiveauEtudeRepository $etudeRepository,
        private readonly DiplomeRepository $diplomeRepository,
        private SpecialiteRepository $specialiteRepository,
        private FormationProfessionnelleRepository $formationProfessionnelleRepository,
        private EntrepreunariatRepository $entrepreunariatRepository
    )
    {
    }

    // BENEFICIAIRE
    public function getOneBeneficiaire(string $matricule = null, object $user = null)
    {
        if ($matricule){
            return $this->beneficiaireRepository->findOneBy(['matricule' => $matricule]);
        }

        if ($user){
            return $this->beneficiaireRepository->findOneBy(['user' => $user]);
        }

        return $this->beneficiaireRepository->findOneBy([],['id' => 'DESC']);
    }

    public function getOneCV(object $user)
    {
        return $this->curiculumRepository->findOneBy(['user' => $user]);
    }

    public function getAllBeneficiaireByStatut(string $statut)
    {
        return $this->beneficiaireRepository->findAllByCategorie($statut);
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
}