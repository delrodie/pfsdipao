<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Entity\Beneficiaire;
use App\Entity\User;
use App\Form\BeneficiaireFormType;
use App\Service\AllRepositories;
use App\Service\GestionMedia;
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
    public function __construct(private readonly AllRepositories $allRepositories, private readonly GestionMedia $gestionMedia, private readonly Utilities $utilities, private readonly UserPasswordHasherInterface $userPasswordHasher, private readonly EntityManagerInterface $entityManager)
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
            $objecif = $request->request->get('beneficiaire_form_objectif');
            $word = $this->utilities->uniciteUser($postulant);
            if (!$word){
                sweetalert()->error("Le numero de telephone est déjà utilisé dans le système", [], 'Echèx');
                return $this->render("backend/postulant_new.html.twig",[
                    'postuant' => $postulant,
                    'form' => $form
                ]);
            }

            // Vérification de l'unicité du postulant
            $slug = $this->utilities->unicitePostulant($postulant);
            if (!$slug){
                sweetalert()->error("Ce postulant a déjà été enregistré",[], "Echèc");
                return $this->render("backend/postulant_new.html.twig",[
                    'postulant' => $postulant,
                    'form' => $form
                ]);
            }

            $this->gestionMedia->media($form, $postulant, 'profile');
            $postulant->setMatricule($this->utilities->matricule());
            $postulant->setClasse($objecif);

            // Nouvel Utilisateur
            $user = new User();
            $user->setUsername($postulant->getTelephone());
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user, $postulant->getNom().$word
                )
            );
            $user->setStatut($objecif);

            $postulant->setUser($user);

            $this->entityManager->persist($postulant);
            $this->entityManager->persist($user);

            $this->entityManager->flush();

            sweetalert()->success("Le postulant {$postulant->getNom()} {$postulant->getPrenom()} a été ajouté avec succès!", ['icon' => 'success'], 'Succès');

            return $this->redirectToRoute('app_backend_postulant_show',[
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
//        dd($beneficiaire);
        return $this->render('backend/postulant_show.html.twig',[
            'postulant' => $beneficiaire
        ]);
    }
}
