<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Entity\Beneficiaire;
use App\Service\AllRepositories;
use App\Service\GestionPostulant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backend/entrepreneuriat')]
class BackendEntrepreneuriatController extends AbstractController
{
    public function __construct(private readonly AllRepositories $allRepositories)
    {
    }

    #[Route('/', name: 'app_backend_entrepreneuriat_index')]
    public function index(): Response
    {
        return $this->render('backend/entrepreneurait_index.html.twig',[
            'beneficiaires' => $this->allRepositories->getAllBeneficiaireByStatutAndClasse(GestionPostulant::STATUT_SELCTIONNER, GestionPostulant::STATUT_BENEFICIAIRE, GestionPostulant::CLASSE_ENTREPRENEURIAT)
        ]);
    }

    #[Route('/{id}', name: 'app_backend_entrepreneuriat_show', methods: ['GET'])]
    public function show(Beneficiaire $beneficiaire): Response
    {
        return $this->render('backend/entrepreneurait_show.html.twig',[
            'postulant' => $beneficiaire,
//            'compte' => $this->allRepositories->getTampon($beneficiaire->getTelephone()),
//            'user' => $this->allRepositories->getOneUser($beneficiaire->getTelephone()),
            'entreprises' => $this->allRepositories->getAllEntrepriseByBeneficiaire($beneficiaire)
        ]);
    }

    #[Route('/{id}/financement', name: 'app_backend_entrepreneuriat_financement', methods: ['GET','POST'])]
    public function financement(Request $request, Beneficiaire $beneficiaire)
    {

    }
}
