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

    public function financement(string  $finance = null): array
    {
        if ($finance) {
            $resultat = [
                'total' => count($this->allRepositories->getAllEntrepriseByStatut($finance)),
                'femme' => count($this->allRepositories->getAllEntrepriseByStatutAndSexe($finance, GestionPostulant::GENRE_FEMME)),
                'homme' => count($this->allRepositories->getAllEntrepriseByStatutAndSexe($finance, GestionPostulant::GENRE_HOMME)),
            ];
        }else{
            $resultat = [
                'total' => count($this->allRepositories->getAllEntrepriseByStatut()),
                'femme' => count($this->allRepositories->getAllEntrepriseByStatutAndSexe(null, GestionPostulant::GENRE_FEMME)),
                'homme' => count($this->allRepositories->getAllEntrepriseByStatutAndSexe(null, GestionPostulant::GENRE_HOMME)),
            ];
        }

        return $resultat;
    }
    public function remboursement(string  $remboursement = null): array
    {
        if ($remboursement) {
            $resultat = [
                'total' => count($this->allRepositories->getAllEntrepriseByRemboursement($remboursement)),
                'femme' => count($this->allRepositories->getAllEntrepriseByRemboursementAndSexe($remboursement, GestionPostulant::GENRE_FEMME)),
                'homme' => count($this->allRepositories->getAllEntrepriseByRemboursementAndSexe($remboursement, GestionPostulant::GENRE_HOMME)),
            ];
        }else{
            $resultat = [
                'total' => count($this->allRepositories->getAllEntrepriseByRemboursement(null, GestionPostulant::FINANCEMENT_ACCORDE)),
                'femme' => count($this->allRepositories->getAllEntrepriseByRemboursementAndSexe(null, GestionPostulant::GENRE_FEMME, GestionPostulant::FINANCEMENT_ACCORDE)),
                'homme' => count($this->allRepositories->getAllEntrepriseByRemboursementAndSexe(null, GestionPostulant::GENRE_HOMME, GestionPostulant::FINANCEMENT_ACCORDE)),
            ];
        }

        return $resultat;
    }
}