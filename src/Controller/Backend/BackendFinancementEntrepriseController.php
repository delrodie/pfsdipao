<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Entity\Entrepreneuriat;
use App\Form\FinancementFormType;
use App\Service\AllRepositories;
use App\Service\GestionPostulant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backend/financement-entreprise')]
class BackendFinancementEntrepriseController extends AbstractController
{
    public function __construct(private readonly GestionPostulant $gestionPostulant, private readonly EntityManagerInterface $entityManager, private readonly AllRepositories $allRepositories)
    {
    }

    #[Route('/', name: 'app_backend_financement_entreprise_index')]
    public function index(): Response
    {
        return $this->render('backend/financement_entreprise_liste.html.twig',[
            'entreprises' => $this->allRepositories->getAllEntreprises()
        ]);
    }

    #[Route('/{statut}/', name: 'app_backend_financement_entreprise_statut', methods: ['GET'])]
    public function statut($statut)
    {
        $entreprises = match ($statut){
            'finance' => $this->allRepositories->getAllEntrepriseByStatut($this->gestionPostulant::FINANCEMENT_ACCORDE),
            'non-finance' => $this->allRepositories->getAllEntrepriseByStatut()
        };

        return $this->render('backend/financement_entreprise_liste.html.twig',[
            'entreprises' => $entreprises
        ]);
    }

    #[Route('/{id}/new', name: 'app_backend_financement_entreprise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Entrepreneuriat $entrepreneuriat)
    {
        $form = $this->createForm(FinancementFormType::class, $entrepreneuriat);
        $form->handleRequest($request);
//        dd($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entrepreneuriat->setStatut($this->gestionPostulant::FINANCEMENT_ACCORDE);
            $entrepreneuriat->getBeneficiaire()->setStatut($this->gestionPostulant::STATUT_BENEFICIAIRE);

            $this->entityManager->flush();

            sweetalert()->success("Le financement du projet d'entreprise a été validé avec succès!");

            return $this->redirectToRoute('app_backend_projet_entreprise_show', ['id' => $entrepreneuriat->getId()]);
        }

        return $this->render('backend/financement_entreprise_new.html.twig', [
            'entrepreneuriat' => $entrepreneuriat,
            'form' => $form,
        ]);
    }
}
