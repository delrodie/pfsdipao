<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Service\AllRepositories;
use App\Service\GestionPostulant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backend/beneficiaire-rst')]
class BackendBeneficiaireRstController extends AbstractController
{
    public function __construct(private readonly AllRepositories $allRepositories)
    {
    }

    #[Route('/', name: 'app_backend_beneficiaire_rst_index')]
    public function index(): Response
    {
        return $this->render('backend/beneficiaire_rst_index.html.twig',[
            'beneficiaires' => $this->allRepositories->getAllBeneficiaireByStatutAndClasse(GestionPostulant::STATUT_SELCTIONNER, GestionPostulant::STATUT_BENEFICIAIRE, GestionPostulant::CLASSE_RST)
        ]);
    }
}
