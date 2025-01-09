<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Statistiques;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    public function __construct(private readonly Statistiques $statistiques)
    {
    }

    #[Route('/dashboard', name: 'app_backend_dashboard')]
    public function index(): Response
    {

        return $this->render('backend/dashboard.html.twig',[
            'classes' => $this->statistiques->classe(),
            'finance' => $this->statistiques->finance(),
            'genres' => $this->statistiques->genre(),
        ]);
    }
}
