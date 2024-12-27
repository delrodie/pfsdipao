<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Entrepreneuriat;
use App\Form\EntrepreneuriatFormType;
use App\Service\AllRepositories;
use App\Service\GestionMedia;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/entrepreneuriat')]
class EntrepreneuriatController extends AbstractController
{
    public function __construct(
        private readonly Utilities     $utilities,
        private readonly GestionMedia  $gestionMedia,
        private EntityManagerInterface $entityManager, private readonly AllRepositories $allRepositories
    )
    {
    }

    #[Route('/', name: 'app_frontend_entrepreneuriat_tbord')]
    public function tbord(): Response
    {
        return $this->render('frontend/entrepreneuriat_tbord.html.twig',[
            'entrepreneuriats' => $this->allRepositories->getAllEntrepreneuriat()
        ]);
    }

    #[Route('/add', name: 'app_frontend_entrepreneuriat_add', methods: ['GET','POST'])]
    public function add(Request $request): Response
    {
        $entrepreneuriat = new Entrepreneuriat();
        $form = $this->createForm(EntrepreneuriatFormType::class, $entrepreneuriat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            // Verification de l'unicité du projet
            $unique = $this->utilities->uniciteEntrepreneuriat($entrepreneuriat);
            if (!$unique){
                sweetalert()->error("Echec! Ce projet a déjà été enregistré dans la liste de vos projets.", [], 'ECHEC!');
                return $this->redirectToRoute('app_frontend_entrepreneuriat_tbord');
            }

            $this->gestionMedia->media($form, $entrepreneuriat, 'entrepreneuriat');

            $entrepreneuriat->setCode($this->utilities->codeEntrepreneuriat());

            $this->entityManager->persist($entrepreneuriat);
            $this->entityManager->flush();

            notyf()->success("Le projet d'entreprise '{$entrepreneuriat->getNomEntreprise()}' a été ajouté avec succes!");

            return $this->redirectToRoute('app_frontend_entrepreneuriat_show',[
                'code' => $entrepreneuriat->getCode()
            ]);
        }

        return $this->render('frontend/entrepreneuriat_add.html.twig',[
            'entrepreneuriat' => $entrepreneuriat,
            'form' => $form
        ]);
    }

    #[Route('/{code}', name: 'app_frontend_entrepreneuriat_show', methods: ['GET'])]
    public function show($code)
    {
        $entrepreneuriat = $this->allRepositories->getOneEntrepreneuriat(null, $code);
        if (!$entrepreneuriat){
            sweetalert()->error("Le projet d'entreprise recherchée n'a pas été trouvée.");
            return $this->redirectToRoute("app_frontend_entrepreneuriat_tbord");
        }

        return $this->render('frontend/entrepreneuriat_show.html.twig', [
            'entrepreneuriat' => $entrepreneuriat
        ]);
    }

    #[Route('/{code}/modification', name: 'app_frontend_entrepreneuriat_edit', methods: ['GET','POST'])]
    public function edit(Request $request, $code)
    {
        $entrepreneuriat = $this->allRepositories->getOneEntrepreneuriat(null, $code);
        if (!$entrepreneuriat){
            sweetalert()->error("Le projet d'entreprise recherchée n'a pas été trouvée.");
            return $this->redirectToRoute("app_frontend_entrepreneuriat_tbord");
        }

        $form = $this->createForm(EntrepreneuriatFormType::class, $entrepreneuriat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->gestionMedia->media($form, $entrepreneuriat, 'entrepreneuriat');

            $this->entityManager->flush();

            notyf()->success("Le projet d'entreprise '{$entrepreneuriat->getNomEntreprise()}' a été modifié avec succes!", [], 'SUCCES!');

            return $this->redirectToRoute('app_frontend_entrepreneuriat_show',[
                'code' => $entrepreneuriat->getCode()
            ]);
        }

        return $this->render('frontend/entrepreneuriat_edit.html.twig',[
            'entrepreneuriat' => $entrepreneuriat,
            'form' => $form
        ]);
    }

    #[Route('/{code}', name: 'app_frontend_entrepreneuriat_delete', methods: ['POST'])]
    public function delete(Request $request, $code): Response
    {
        $entrepreneuriat = $this->allRepositories->getOneEntrepreneuriat(null, $code);
        if (!$entrepreneuriat){
            sweetalert()->error("Le projet d'entreprise recherchée n'a pas été trouvée.");
            return $this->redirectToRoute("app_frontend_entrepreneuriat_tbord");
        }

        if ($this->isCsrfTokenValid('delete'.$entrepreneuriat->getId(), $request->getPayload()->getString('_token'))) {
            $this->entityManager->remove($entrepreneuriat);
            $this->entityManager->flush();

            notyf()->success("Le projet d'entreprise {$entrepreneuriat->getNomEntreprise()} a été supprimer avec succès!", [], 'SUCCES!');
        }

        return $this->redirectToRoute('app_frontend_entrepreneuriat_tbord', [], Response::HTTP_SEE_OTHER);
    }
}
