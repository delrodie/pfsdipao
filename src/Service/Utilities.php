<?php

namespace App\Service;

use App\Entity\Entrepreneuriat;
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
            'formation' => $this->allRepositories->getOneFormationProfessionelle($slug),
            default => $this->allRepositories->getOneNiveauEtude($slug)
        };

        if ($entity) return false;

        return $slug;
    }

    public function uniciteEntrepreneuriat(Entrepreneuriat $entrepreneuriat): bool
    {
        $slug = $this->slug(
            $entrepreneuriat->getNomEntreprise().'-'.$entrepreneuriat->getIntitule()
        );

        $verification = $this->allRepositories->getOneEntrepreneuriat($slug);
        if ($verification)return false;

        $entrepreneuriat->setSlug($slug);

        return true;
    }

    public function codeEntrepreneuriat(): string
    {
        do{
            $code = date('ym').random_int(100,999);
            $verif = $this->allRepositories->getOneEntrepreneuriat(null, $code);
        }while($verif);

        return $code;
    }

    public function uniciteUser(object $postulant): false|int
    {
        $user = $this->allRepositories->findOneUser($postulant->getTelephone());
        if ($user) return false;

        return random_int(1000,9999);
    }

    public function unicitePostulant(object $postulant)
    {
        $slug = $this->slug(
            $postulant->getNom().'-'
            .$postulant->getPrenom().'-'
            .$postulant->getTelephone()
        );

        $verification = $this->allRepositories->getOneBeneficiaire(null, null, $slug);
        if ($verification){
            return false;
        }

        return $postulant->setSlug($slug);
    }
}