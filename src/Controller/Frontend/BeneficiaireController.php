<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/beneficiaire')]
class BeneficiaireController extends AbstractController
{
    #[Route('/', name: "app_frontend_beneficiaire_profile")]
    public function profile(): Response
    {
        return $this->render('frontend/beneficiaire_profile.html.twig');
    }
}
