<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Entity\Beneficiaire;
use App\Entity\Entrepreneuriat;
use App\Form\EntrepreneuriatFormType;
use App\Service\GestionMedia;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/backend/projet-entreprise')]
class BackendProjetEntrepriseController extends AbstractController
{
    public function __construct(private readonly Utilities $utilities, private readonly GestionMedia $gestionMedia, private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/')]
    public function index(): Response
    {
        return $this->render('backend_projet_entreprise/index.html.twig');
    }

    #[Route('/{beneficiaire}/new', name: 'app_backend_projet_entreprise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Beneficiaire $beneficiaire)
    {
        $entreprise = new Entrepreneuriat();
        $form = $this->createForm(EntrepreneuriatFormType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérification de l'unicité du projet
            if (!$this->utilities->uniciteEntrepreneuriat($entreprise)){
                sweetalert()->error("Ce projet a déjà été enregistré dans la liste de vos projets.", [], 'ECHEC!');
                return $this->render('backend/projet_entreprise_new.html.twig', [
                    'beneficiaire' => $beneficiaire,
                    'form' => $form,
                ]);
            }

            $this->gestionMedia->media($form, $entreprise, 'entrepreneuriat');

            $entreprise->setCode($this->utilities->codeEntrepreneuriat());
            $entreprise->setBeneficiaire($beneficiaire);

            $this->entityManager->persist($entreprise);
            $this->entityManager->flush();

            sweetalert()->success("Le projet d'entreprise {$entreprise->getNomEntreprise()} a été ajouté avec succès!", [], 'SUCCES!');

            return $this->redirectToRoute('app_backend_projet_entreprise_show', [
                'id' => $entreprise->getId()
            ]);
        }

        return $this->render('backend/projet_entreprise_new.html.twig', [
            'beneficiaire' => $beneficiaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_projet_entreprise_show', methods: ['GET'])]
    public function show(Entrepreneuriat $entrepreneuriat): Response
    {
        return $this->render('backend/projet_entreprise_show.html.twig', [
            'entrepreneuriat' => $entrepreneuriat,
        ]);
    }

    #[Route('/{id}/modifier/projet', name: 'app_backend_projet_entreprise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entrepreneuriat $entrepreneuriat): Response
    {
        $form = $this->createForm(EntrepreneuriatFormType::class, $entrepreneuriat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->gestionMedia->media($form, $entrepreneuriat, 'entrepreneuriat');

            $entrepreneuriat->setCode($this->utilities->codeEntrepreneuriat());

            $this->entityManager->persist($entrepreneuriat);
            $this->entityManager->flush();

            sweetalert()->success("Le projet d'entreprise {$entrepreneuriat->getNomEntreprise()} a été ajouté avec succès!", [], 'SUCCES!');

            return $this->redirectToRoute('app_backend_projet_entreprise_show', [
                'id' => $entrepreneuriat->getId()
            ]);
        }

        return $this->render('backend/projet_entreprise_edit.html.twig', [
            'entrepreneuriat' => $entrepreneuriat,
            'form' => $form,
        ]);
    }


}
