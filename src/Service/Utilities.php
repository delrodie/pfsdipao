<?php

namespace App\Service;

use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\AsciiSlugger;

class Utilities
{
    public function __construct(
        private AllRepositories $allRepositories
    )
    {
    }

    public function matricule(): string
    {
        do{
            $nombreAleatoire = random_int(100,999);
            $codeDate = date("ym");
            $lettreAleatoire = chr(rand(65, 90));
            $matricule = $codeDate.$nombreAleatoire.$lettreAleatoire;

            $verif = $this->allRepositories->getOneBeneficiaire($matricule);
        } while($verif);

        return $matricule;
    }

    public function slug(string $string): AbstractUnicodeString
    {
        return (new AsciiSlugger())->slug(strtolower($string));
    }

    // importation des fichiers Excel
    public function importNiveau(string $title): AbstractUnicodeString|false
    {
        $slug = $this->slug($title);
        $verif = $this->allRepositories->getOneNiveauEtude($slug);

        if ($verif) return false;

        return $slug;
    }

    public function importExcel(string $title, string $entityName): AbstractUnicodeString|false
    {
        $slug = $this->slug($title);

        $entity = match ($entityName){
            'diplome' => $this->allRepositories->getOneDiplome($slug),
            'specialite' => $this->allRepositories->getOneSpecialite($slug),
            default => $this->allRepositories->getOneNiveauEtude($slug)
        };

        if ($entity) return false;

        return $slug;
    }
}