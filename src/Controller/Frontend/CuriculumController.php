<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Curiculum;
use App\Form\CuriculumFormType;
use App\Service\AllRepositories;
use App\Service\GestionMedia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/curiculum')]
class CuriculumController extends AbstractController
{
    public function __construct(
        private AllRepositories $allRepositories,
        private GestionMedia $gestionMedia,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/', name: 'app_frontend_curiculum_upload', methods: ['GET','POST'])]
    public function upload(Request $request): Response
    {
        $verif = $this->allRepositories->getOneCV($this->getUser());
        if ($verif){
            dd('ici');
        }

        $cv = new Curiculum();
        $form = $this->createForm(CuriculumFormType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->gestionMedia->media($form, $cv, 'cv');
            $cv->setUser($this->getUser());

            $this->entityManager->persist($cv);
            $this->entityManager->flush();

            notyf()->success("Votre CV a été enregistré avec succès.", [], 'SUCCES');

            return $this->redirectToRoute('app_frontend_curiculum_show');
        }
        return $this->render('frontend/curiculum_upload.html.twig', [
            'cv' => $cv,
            'form' => $form
        ]);
    }

    #[Route('/details', name: 'app_frontend_curiculum_show')]
    public function show()
    {
        $cv = $this->allRepositories->getOneCV($this->getUser());

        return $this->render('frontend/curiculum_show.html.twig',[
            'cv' => $cv
        ]);
    }
}
