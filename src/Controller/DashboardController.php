<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\GestionPostulant;
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
//        dd();

        return $this->render('backend/dashboard.html.twig',[
            'classes' => $this->statistiques->classe(),
            'finance' => $this->statistiques->finance(),
            'genres' => $this->statistiques->genre(),
            'accorde' => $this->statistiques->financement(GestionPostulant::FINANCEMENT_ACCORDE),
            'non_accorde' => $this->statistiques->financement(),
            'rembourse' => $this->statistiques->remboursement(GestionPostulant::FINANCEMENT_REMBOURSE),
            'non_rembourse' => $this->statistiques->remboursement(),
        ]);
    }
}
