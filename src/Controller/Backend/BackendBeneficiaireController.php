<?php

namespace App\Controller\Backend;

use App\Entity\Beneficiaire;
use App\Form\BeneficiaireType;
use App\Repository\BeneficiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backend/beneficiaire')]
final class BackendBeneficiaireController extends AbstractController
{
    #[Route('/{statut}', name: 'app_backend_beneficiaire_index', methods: ['GET', 'POST'])]
    public function index(BeneficiaireRepository $beneficiaireRepository, $statut): Response
    {
        return $this->render('backend_beneficiaire/index.html.twig', [
            'beneficiaires' => $beneficiaireRepository->findAllByCategorie($statut),
        ]);
    }

    #[Route('/new', name: 'app_backend_beneficiaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $beneficiaire = new Beneficiaire();
        $form = $this->createForm(BeneficiaireType::class, $beneficiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($beneficiaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_beneficiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_beneficiaire/new.html.twig', [
            'beneficiaire' => $beneficiaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_beneficiaire_show', methods: ['GET'])]
    public function show(Beneficiaire $beneficiaire): Response
    {
        return $this->render('backend_beneficiaire/show.html.twig', [
            'beneficiaire' => $beneficiaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backend_beneficiaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Beneficiaire $beneficiaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BeneficiaireType::class, $beneficiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_beneficiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_beneficiaire/edit.html.twig', [
            'beneficiaire' => $beneficiaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_beneficiaire_delete', methods: ['POST'])]
    public function delete(Request $request, Beneficiaire $beneficiaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$beneficiaire->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($beneficiaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backend_beneficiaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
