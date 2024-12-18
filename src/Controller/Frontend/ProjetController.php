<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projet')]
class ProjetController extends AbstractController
{
    #[Route('/', name: 'app_frontend_projet_tbord')]
    public function tbord(): Response
    {
        return $this->render('frontend/projet_tbord.html.twig');
    }

    #[Route('/add', name: 'app_frontend_projet_add', methods: ['GET','POST'])]
    public function add(Request $request)
    {
        return $this->render('frontend/projet_add.html.twig');
    }
}
