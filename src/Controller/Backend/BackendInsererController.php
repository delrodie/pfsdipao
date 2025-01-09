<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Service\AllRepositories;
use App\Service\GestionPostulant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backend/les-inseres')]
class BackendInsererController extends AbstractController
{
    public function __construct(private readonly AllRepositories $allRepositories)
    {
    }

    #[Route('/', name: 'app_backend_inserer_index')]
    public function index(): Response
    {
        return $this->render('backend/inserer_index.html.twig',[
            'beneficiaires' => $this->allRepositories->getAllInseres()
        ]);
    }

    #[Route('/{classe}', name: 'app_backend_inserer_classe', methods: ['GET'])]
    public function classe($classe): Response
    {
        return $this->render('backend/inserer_index.html.twig',[
            'beneficiaires' => $this->allRepositories->getBeneficiaireByStatutAndClasse(GestionPostulant::STATUT_BENEFICIAIRE, $classe)
        ]);
    }
}
