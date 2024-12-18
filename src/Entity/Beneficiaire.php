<?php

namespace App\Entity;

use App\Repository\BeneficiaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BeneficiaireRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Beneficiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieuNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media = null;

    #[ORM\Column(nullable: true)]
    private ?int $enfantFamille = null;

    #[ORM\Column(nullable: true)]
    private ?int $enfantCharge = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matrimoniale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hebergement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeRessource = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomRessource = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephoneRessource = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseRessource = null;

    #[ORM\Column(nullable: true)]
    private ?bool $analphabete = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveauEtude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $diplome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveauFormation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $natureFormation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?string $lieuNaissance): static
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getEnfantFamille(): ?int
    {
        return $this->enfantFamille;
    }

    public function setEnfantFamille(?int $enfantFamille): static
    {
        $this->enfantFamille = $enfantFamille;

        return $this;
    }

    public function getEnfantCharge(): ?int
    {
        return $this->enfantCharge;
    }

    public function setEnfantCharge(?int $enfantCharge): static
    {
        $this->enfantCharge = $enfantCharge;

        return $this;
    }

    public function getMatrimoniale(): ?string
    {
        return $this->matrimoniale;
    }

    public function setMatrimoniale(?string $matrimoniale): static
    {
        $this->matrimoniale = $matrimoniale;

        return $this;
    }

    public function getHebergement(): ?string
    {
        return $this->hebergement;
    }

    public function setHebergement(?string $hebergement): static
    {
        $this->hebergement = $hebergement;

        return $this;
    }

    public function getTypeRessource(): ?string
    {
        return $this->typeRessource;
    }

    public function setTypeRessource(?string $typeRessource): static
    {
        $this->typeRessource = $typeRessource;

        return $this;
    }

    public function getNomRessource(): ?string
    {
        return $this->nomRessource;
    }

    public function setNomRessource(?string $nomRessource): static
    {
        $this->nomRessource = $nomRessource;

        return $this;
    }

    public function getTelephoneRessource(): ?string
    {
        return $this->telephoneRessource;
    }

    public function setTelephoneRessource(?string $telephoneRessource): static
    {
        $this->telephoneRessource = $telephoneRessource;

        return $this;
    }

    public function getAdresseRessource(): ?string
    {
        return $this->adresseRessource;
    }

    public function setAdresseRessource(?string $adresseRessource): static
    {
        $this->adresseRessource = $adresseRessource;

        return $this;
    }

    public function isAnalphabete(): ?bool
    {
        return $this->analphabete;
    }

    public function setAnalphabete(?bool $analphabete): static
    {
        $this->analphabete = $analphabete;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(?string $niveauEtude): static
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(?string $diplome): static
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getNiveauFormation(): ?string
    {
        return $this->niveauFormation;
    }

    public function setNiveauFormation(?string $niveauFormation): static
    {
        $this->niveauFormation = $niveauFormation;

        return $this;
    }

    public function getNatureFormation(): ?string
    {
        return $this->natureFormation;
    }

    public function setNatureFormation(?string $natureFormation): static
    {
        $this->natureFormation = $natureFormation;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?\Symfony\Component\String\AbstractUnicodeString $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): \DateTime
    {
        return $this->createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }
}
