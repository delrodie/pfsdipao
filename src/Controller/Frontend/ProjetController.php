<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projet')]
class ProjetController extends AbstractController
{
    #[Route('/tbord', name: 'app_frontend_projet_tbord')]
    public function tbord(): Response
    {
        return $this->render('frontend/projet_tbord.html.twig');
    }
}
