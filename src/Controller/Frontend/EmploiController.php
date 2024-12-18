<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/emploi')]
class EmploiController extends AbstractController
{
    #[Route('/tbord', name: "app_frontend_emploi_tbord")]
    public function tbord(): Response
    {
        return $this->render('frontend/emploi_tbord.html.twig');
    }
}
