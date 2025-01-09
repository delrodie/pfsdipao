<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Entity\Beneficiaire;
use App\Entity\Tampon;
use App\Entity\User;
use App\Form\BeneficiaireFormType;
use App\Service\AllRepositories;
use App\Service\GestionMedia;
use App\Service\GestionPostulant;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backend/postulant')]
class BackendPostulantController extends AbstractController
{
    public function __construct(private readonly AllRepositories $allRepositories, private readonly GestionMedia $gestionMedia, private readonly Utilities $utilities, private readonly UserPasswordHasherInterface $userPasswordHasher, private readonly EntityManagerInterface $entityManager, private readonly GestionPostulant $gestionPostulant)
    {
    }

    #[Route('/', name: 'app_backend_postulant_index')]
    public function index(): Response
    {
        return $this->render('backend/postulant_index.html.twig',[
            'postulants' => $this->allRepositories->getAllPostulant()
        ]);
    }

    #[Route('/new', name: 'app_backend_postulant_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $postulant = new Beneficiaire();
        $form = $this->createForm(BeneficiaireFormType::class, $postulant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            // Gestion des erreurs d'unicité
            if (!$this->gestionPostulant->valideUniquePostulant($postulant)){
                return $this->render("backend/postulant_new.html.twig",[
                    'postuant' => $postulant,
                    'form' => $form
                ]);
            }

            // Traitement des données du postulant
            $this->gestionPostulant->processPostulantData($postulant, $request, $form);
            sweetalert()->success(
                "Le postulant {$postulant->getNom()} {$postulant->getPrenom()} a été ajouté avec succès!",
                ['icon' => 'success'],
                'Succès'
            );

            return $this->redirectToRoute('app_backend_postulant_show', [
                'id' => $postulant->getId()
            ]);
        }

        return $this->render('backend/postulant_new.html.twig',[
            'postulant' => $postulant,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_backend_postulant_show', methods: ['GET'])]
    public function show(Beneficiaire $beneficiaire): Response
    {
        return $this->render('backend/postulant_show.html.twig',[
            'postulant' => $beneficiaire,
            'compte' => $this->allRepositories->getTampon($beneficiaire->getTelephone()),
            'user' => $this->allRepositories->getOneUser($beneficiaire->getTelephone()),
        ]);
    }
    #[Route('/{id}/edit', name: 'app_backend_postulant_edit', methods: ['GET','POST'])]
    public function edit(Beneficiaire $beneficiaire, Request $request): Response
    {
        $form = $this->createForm(BeneficiaireFormType::class, $beneficiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $objectif = $request->request->get('beneficiaire_form_objectif');
            $this->gestionMedia->media($form, $beneficiaire, 'profile');

            $beneficiaire->setClasse($objectif);

            $this->entityManager->flush();

            sweetalert()->success("Le postulant {$beneficiaire->getNom()} a été modifié avec succès!");

            return $this->redirectToRoute('app_backend_postulant_show', [
                'id' => $beneficiaire->getId()
            ]);
        }

        return $this->render('backend/postulant_edit.html.twig',[
            'postulant' => $beneficiaire,
            'form' => $form
        ]);
    }

    #[Route('/{id}/select/ok', name: 'app_backend_postulant_select', methods: ['POST'])]
    public function select(Request $request, Beneficiaire $beneficiaire)
    {
        $redirectLink = 'app_backend_postulant_show';
        if ($this->isCsrfTokenValid('select'.$beneficiaire->getId(), $request->getPayload()->getString('_token'))) {
//            dd($beneficiaire);
            $beneficiaire->setStatut('SELECTIONNER');
            $this->entityManager->flush();

            $redirectLink = match ($beneficiaire->getClasse()) {
                'EMPLOI', 'RST' => 'app_backend_emploi_show',
                'ENTREPRENEURIAT' => 'app_backend_entrepreneuriat_show',
                'FORMATION' => 'app_backend_beneficiaire_forme_show',
                default => 'app_backend_postulant_show'
            };
        }

        return $this->redirectToRoute($redirectLink, [
            'id' => $beneficiaire->getId()
        ], Response::HTTP_SEE_OTHER);
    }

}
