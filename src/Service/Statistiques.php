<?php

namespace App\Service;

use App\Service\AllRepositories;
use phpDocumentor\Reflection\Types\This;

class Statistiques
{
    public function __construct(private readonly AllRepositories $allRepositories)
    {
    }

    public function classe(): array
    {
        $classes = [GestionPostulant::CLASSE_EMPLOI, GestionPostulant::CLASSE_ENTREPRENEURIAT, GestionPostulant::CLASSE_FORMATION, GestionPostulant::CLASSE_RST];
        $statistiques = []; $i = 0;

        foreach ($classes as $classe) {
            $statistiques[$i++] =[
                'titre' => $classe,
                'nb' => count($this->allRepositories->getBeneficiaireByStatutAndClasse(GestionPostulant::STATUT_BENEFICIAIRE, $classe))
            ];
        }
        return $statistiques;
    }
    public function genre(): array
    {
        $classes = [GestionPostulant::CLASSE_EMPLOI, GestionPostulant::CLASSE_ENTREPRENEURIAT, GestionPostulant::CLASSE_FORMATION, GestionPostulant::CLASSE_RST];
        $statistiques = []; $i = 0;

        foreach ($classes as $classe) {
            $statistiques[$i++] =[
                'titre' => $classe,
                'homme' => count($this->allRepositories->getBeneficiaireByStatutClasseAndSexe(GestionPostulant::STATUT_BENEFICIAIRE, $classe, GestionPostulant::GENRE_HOMME)),
                'femme' => count($this->allRepositories->getBeneficiaireByStatutClasseAndSexe(GestionPostulant::STATUT_BENEFICIAIRE, $classe, GestionPostulant::GENRE_FEMME)),
                'total' => count($this->allRepositories->getBeneficiaireByStatutAndClasse(GestionPostulant::STATUT_BENEFICIAIRE, $classe)),
            ];
        }
        return $statistiques;
    }

    public function finance()
    {
        return $this->allRepositories->getTotalFinance();
    }
}