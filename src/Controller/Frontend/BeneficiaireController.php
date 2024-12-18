<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Beneficiaire;
use App\Form\BeneficiaireFormType;
use App\Service\AllRepositories;
use App\Service\GestionMedia;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/beneficiaire')]
class BeneficiaireController extends AbstractController
{
    public function __construct(
        private AllRepositories $allRepositories,
        private EntityManagerInterface $entityManager,
        private GestionMedia $gestionMedia,
        private Utilities $utilities
    )
    {

    }
    #[Route('/', name: "app_frontend_beneficiaire_profile")]
    public function profile(Request $request): Response
    {
        // Verification de l'existance du bénéficiaire
        $verif = $this->allRepositories->getOneBeneficiaire(null, $this->getUser());
        if ($verif){
            return $this->redirectToRoute('app_frontend_beneficiaire_show',[
                'matricule' => $verif->getMatricule()
            ]);
        }

        $beneficiaire = new Beneficiaire();
        $form = $this->createForm(BeneficiaireFormType::class, $beneficiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->gestionMedia->media($form, $beneficiaire, 'profile');
            $beneficiaire->setMatricule($this->utilities->matricule());

            $beneficiaire->setSlug($this->utilities->slug(
                $beneficiaire->getNom().'-'
                .$beneficiaire->getPrenom().'-'
                .$beneficiaire->getTelephone()
            ));

            $beneficiaire->setUser($this->getUser());

            $this->entityManager->persist($beneficiaire);
            $this->entityManager->flush();

            notyf()->success("Votre profile a été enregistré avec succès!");

            return $this->redirectToRoute('app_frontend_beneficiaire_show',[
                'matricule' => $beneficiaire->getMatricule()
            ]);
        }
        return $this->render('frontend/beneficiaire_profile.html.twig', [
            'beneficiaire' => $beneficiaire,
            'form' => $form
        ]);
    }

    #[Route('/{matricule}', name: "app_frontend_beneficiaire_show", methods: ['GET'])]
    public function show($matricule): Response
    {
        $beneficiaire = $this->allRepositories->getOneBeneficiaire($matricule);
        if (!$beneficiaire){
            sweetalert()->error("Le matricule n'a pas été trouvé. Veuillez-vous enregistrer",[],'Echec!');

            return $this->redirectToRoute('app_frontend_beneficiaire_profile');
        }

        return $this->render('frontend/beneficiaire_show.html.twig',[
            'beneficiaire' => $beneficiaire
        ]);
    }

    #[Route('/{matricule}/modifier', name: 'app_frontend_beneficiaire_modifier', methods: ['GET', 'POST'])]
    public function modifier(Request $request, $matricule): Response
    {
        // Verification de l'existance du bénéficiaire
        $beneficiaire = $this->allRepositories->getOneBeneficiaire(null, $this->getUser());
        if (!$beneficiaire){
            sweetalert()->error("Votre compte n'est pas associé à un profile. Veuillez vous inscire",[], 'Echèc!');
            return $this->redirectToRoute('app_frontend_beneficiaire_profile');
        }

        $form = $this->createForm(BeneficiaireFormType::class, $beneficiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->gestionMedia->media($form, $beneficiaire, 'profile');

            $beneficiaire->setSlug($this->utilities->slug(
                $beneficiaire->getNom().'-'
                .$beneficiaire->getPrenom().'-'
                .$beneficiaire->getTelephone()
            ));

            $this->entityManager->flush();

            notyf()->success("Votre profile a été modifié avec succès!");

            return $this->redirectToRoute('app_frontend_beneficiaire_show',[
                'matricule' => $beneficiaire->getMatricule()
            ]);
        }
        return $this->render('frontend/beneficiaire_profile_edit.html.twig', [
            'beneficiaire' => $beneficiaire,
            'form' => $form
        ]);
    }
}
