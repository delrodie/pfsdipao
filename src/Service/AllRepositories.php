<?php

namespace App\Service;

use App\Repository\BeneficiaireRepository;
use App\Repository\CuriculumRepository;

class AllRepositories
{
    public function __construct(
        private BeneficiaireRepository $beneficiaireRepository,
        private CuriculumRepository $curiculumRepository,
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
}