<?php

namespace App\Service;

use App\Repository\BeneficiaireRepository;

class AllRepositories
{
    public function __construct(
        private BeneficiaireRepository $beneficiaireRepository,
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
}