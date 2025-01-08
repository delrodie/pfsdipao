<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Entity\Beneficiaire;
use App\Entity\Emploi;
use App\Form\BeneficiaireFormType;
use App\Form\EmploiFormType;
use App\Service\AllRepositories;
use App\Service\GestionPostulant;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backend/emploi')]
class BackendEmploiController extends AbstractController
{
    public function __construct(private readonly AllRepositories $allRepositories, private readonly Utilities $utilities, private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'app_backend_emploi_index')]
    public function index(): Response
    {
        return $this->render('backend/emploi_index.html.twig',[
            'beneficiaires' => $this->allRepositories->getAllBeneficiaireByStatutAndClasse(GestionPostulant::STATUT_SELCTIONNER, GestionPostulant::STATUT_BENEFICIAIRE, GestionPostulant::CLASSE_EMPLOI)
        ]);
    }

    #[Route('/{id}', name: 'app_backend_emploi_show', methods: ['GET'])]
    public function show(Beneficiaire $beneficiaire): Response
    {
        return $this->render('backend/emploi_show.html.twig',[
            'postulant' => $beneficiaire,
            'compte' => $this->allRepositories->getTampon($beneficiaire->getTelephone()),
            'user' => $this->allRepositories->getOneUser($beneficiaire->getTelephone()),
            'emplois' => $this->allRepositories->getAllEmploiByBeneficiaire($beneficiaire)
        ]);

    }

    #[Route('/{id}/insertion', name: 'app_backend_emploi_insertion', methods: ['GET','POST'])]
    public function insertion(Request $request, Beneficiaire $beneficiaire): Response
    {
        $emploi = new Emploi();
        $form = $this->createForm(EmploiFormType::class, $emploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if (!$this->utilities->uniciteEmploi($beneficiaire, $emploi)){
                sweetalert()->error("Attention ce postulant a été déjà inseré dans la même entreprise à la même date");
                return $this->redirectToRoute('app_backend_emploi_show',[
                    'id' => $beneficiaire->getId()
                ]);
            }

            $emploi->setBeneficiaire($beneficiaire);
            $beneficiaire->setStatut(GestionPostulant::STATUT_BENEFICIAIRE);

            $this->entityManager->persist($emploi);
            $this->entityManager->flush();

            sweetalert()->success("Le postulant {$beneficiaire->getNom()} {$beneficiaire->getPrenom()} a été inséré avec succès");

            return $this->redirectToRoute('app_backend_emploi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/emploi_insertion.html.twig',[
            'postulant' => $beneficiaire,
            'form' => $form,
        ]);
    }
}
