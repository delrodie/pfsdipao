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
}