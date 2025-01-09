<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Entity\Beneficiaire;
use App\Entity\Formation;
use App\Form\BeneficiaireFormationType;
use App\Service\AllRepositories;
use App\Service\GestionPostulant;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backend/beneficiaire-forme')]
class BackendBeneficiaireFormeController extends AbstractController
{
    public function __construct(private readonly AllRepositories $allRepositories, private readonly Utilities $utilities, private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'app_backend_beneficiaire_forme_index')]
    public function index(): Response
    {
        return $this->render('backend/beneficiaire_forme_index.html.twig', [
            'beneficiaires' => $this->allRepositories->getAllBeneficiaireByStatutAndClasse(GestionPostulant::STATUT_SELCTIONNER, GestionPostulant::STATUT_BENEFICIAIRE, GestionPostulant::CLASSE_FORMATION)
        ]);
    }

    #[Route('/{id}', name: 'app_backend_beneficiaire_forme_show', methods: ['GET'])]
    public function show(Beneficiaire $beneficiaire)
    {
        return $this->render('backend/beneficiaire_forme_show.html.twig',[
            'postulant' => $beneficiaire,
            'compte' => $this->allRepositories->getTampon($beneficiaire->getTelephone()),
            'user' => $this->allRepositories->getOneUser($beneficiaire->getTelephone()),
            'formations' => $this->allRepositories->getAllFormationByBeneficiaire($beneficiaire)
        ]);
    }

    #[Route('/{id}/insertion', name: 'app_backend_beneficiaire_forme_insertion', methods: ['GET','POST'])]
    public function insertion(Request $request, Beneficiaire $beneficiaire)
    {
        $formation = new Formation();
        $form = $this->createForm(BeneficiaireFormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if ($this->utilities->uniciteFormation($beneficiaire, $formation)){
                sweetalert()->error("Attention! Ce postulant a déjà suivi cette formation");

                return $this->render('backend/beneficiaire_forme_insertion.html.twig', [
                    'postulant' => $beneficiaire,
                    'form' => $form,
                ]);
            }

            $formation->setBeneficiaire($beneficiaire);
            $beneficiaire->setStatut(GestionPostulant::STATUT_BENEFICIAIRE);

            $this->entityManager->persist($formation);
            $this->entityManager->flush();

            sweetalert()->success("Ce postulant a été inséré avec succès!");

            return $this->redirectToRoute('app_backend_beneficiaire_forme_show', ['id' => $beneficiaire->getId()]);
        }

        return $this->render('backend/beneficiaire_forme_insertion.html.twig', [
            'postulant' => $beneficiaire,
            'form' => $form,
        ]);
    }
}
