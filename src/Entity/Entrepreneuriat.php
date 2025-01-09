<?php

namespace App\Entity;

use App\Repository\EntrepreunariatRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepreunariatRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Entrepreneuriat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intitule = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $objectif = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomEntreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeEntreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $produitPropose = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $force = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $matierePremiere = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lieuMatierePremiere = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $clientActuel = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $clientFutur = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $concurrent = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prixProduit = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $beneficeProduit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fixeProduit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modePaiement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modeVente = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $promotion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomAval = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $dateNaissanceAval = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieuNaissanceAval = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $residenceAval = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $professionAval = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephoneAval = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailAval = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media = null;

    #[ORM\Column(nullable: true)]
    private ?int $montantChiffre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $montantLettre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modeRemboursement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $autreMode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\ManyToOne]
    private ?Beneficiaire $beneficiaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?int $montantFinance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFinancement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statutRemboursement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(?string $objectif): static
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(?string $nomEntreprise): static
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getTypeEntreprise(): ?string
    {
        return $this->typeEntreprise;
    }

    public function setTypeEntreprise(?string $typeEntreprise): static
    {
        $this->typeEntreprise = $typeEntreprise;

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

    public function getProduitPropose(): ?string
    {
        return $this->produitPropose;
    }

    public function setProduitPropose(?string $produitPropose): static
    {
        $this->produitPropose = $produitPropose;

        return $this;
    }

    public function getForce(): ?string
    {
        return $this->force;
    }

    public function setForce(?string $force): static
    {
        $this->force = $force;

        return $this;
    }

    public function getMatierePremiere(): ?string
    {
        return $this->matierePremiere;
    }

    public function setMatierePremiere(?string $matierePremiere): static
    {
        $this->matierePremiere = $matierePremiere;

        return $this;
    }

    public function getLieuMatierePremiere(): ?string
    {
        return $this->lieuMatierePremiere;
    }

    public function setLieuMatierePremiere(?string $lieuMatierePremiere): static
    {
        $this->lieuMatierePremiere = $lieuMatierePremiere;

        return $this;
    }

    public function getClientActuel(): ?string
    {
        return $this->clientActuel;
    }

    public function setClientActuel(?string $clientActuel): static
    {
        $this->clientActuel = $clientActuel;

        return $this;
    }

    public function getClientFutur(): ?string
    {
        return $this->clientFutur;
    }

    public function setClientFutur(?string $clientFutur): static
    {
        $this->clientFutur = $clientFutur;

        return $this;
    }

    public function getConcurrent(): ?string
    {
        return $this->concurrent;
    }

    public function setConcurrent(?string $concurrent): static
    {
        $this->concurrent = $concurrent;

        return $this;
    }

    public function getPrixProduit(): ?string
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(?string $prixProduit): static
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getBeneficeProduit(): ?string
    {
        return $this->beneficeProduit;
    }

    public function setBeneficeProduit(?string $beneficeProduit): static
    {
        $this->beneficeProduit = $beneficeProduit;

        return $this;
    }

    public function getFixeProduit(): ?string
    {
        return $this->fixeProduit;
    }

    public function setFixeProduit(?string $fixeProduit): static
    {
        $this->fixeProduit = $fixeProduit;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(?string $modePaiement): static
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    public function getModeVente(): ?string
    {
        return $this->modeVente;
    }

    public function setModeVente(?string $modeVente): static
    {
        $this->modeVente = $modeVente;

        return $this;
    }

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(?string $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getNomAval(): ?string
    {
        return $this->nomAval;
    }

    public function setNomAval(?string $nomAval): static
    {
        $this->nomAval = $nomAval;

        return $this;
    }

    public function getDateNaissanceAval(): ?\DateTimeInterface
    {
        return $this->dateNaissanceAval;
    }

    public function setDateNaissanceAval(?\DateTimeInterface $dateNaissanceAval): static
    {
        $this->dateNaissanceAval = $dateNaissanceAval;

        return $this;
    }

    public function getLieuNaissanceAval(): ?string
    {
        return $this->lieuNaissanceAval;
    }

    public function setLieuNaissanceAval(?string $lieuNaissanceAval): static
    {
        $this->lieuNaissanceAval = $lieuNaissanceAval;

        return $this;
    }

    public function getResidenceAval(): ?string
    {
        return $this->residenceAval;
    }

    public function setResidenceAval(?string $residenceAval): static
    {
        $this->residenceAval = $residenceAval;

        return $this;
    }

    public function getProfessionAval(): ?string
    {
        return $this->professionAval;
    }

    public function setProfessionAval(?string $professionAval): static
    {
        $this->professionAval = $professionAval;

        return $this;
    }

    public function getTelephoneAval(): ?string
    {
        return $this->telephoneAval;
    }

    public function setTelephoneAval(?string $telephoneAval): static
    {
        $this->telephoneAval = $telephoneAval;

        return $this;
    }

    public function getEmailAval(): ?string
    {
        return $this->emailAval;
    }

    public function setEmailAval(?string $emailAval): static
    {
        $this->emailAval = $emailAval;

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

    public function getMontantChiffre(): ?int
    {
        return $this->montantChiffre;
    }

    public function setMontantChiffre(?int $montantChiffre): static
    {
        $this->montantChiffre = $montantChiffre;

        return $this;
    }

    public function getMontantLettre(): ?string
    {
        return $this->montantLettre;
    }

    public function setMontantLettre(?string $montantLettre): static
    {
        $this->montantLettre = $montantLettre;

        return $this;
    }

    public function getModeRemboursement(): ?string
    {
        return $this->modeRemboursement;
    }

    public function setModeRemboursement(?string $modeRemboursement): static
    {
        $this->modeRemboursement = $modeRemboursement;

        return $this;
    }

    public function getAutreMode(): ?string
    {
        return $this->autreMode;
    }

    public function setAutreMode(?string $autreMode): static
    {
        $this->autreMode = $autreMode;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getBeneficiaire(): ?Beneficiaire
    {
        return $this->beneficiaire;
    }

    public function setBeneficiaire(?Beneficiaire $beneficiaire): static
    {
        $this->beneficiaire = $beneficiaire;

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

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): \DateTime
    {
        return $this->createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): \DateTime
    {
        return $this->updateAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    public function getMontantFinance(): ?int
    {
        return $this->montantFinance;
    }

    public function setMontantFinance(?int $montantFinance): static
    {
        $this->montantFinance = $montantFinance;

        return $this;
    }

    public function getDateFinancement(): ?\DateTimeInterface
    {
        return $this->dateFinancement;
    }

    public function setDateFinancement(?\DateTimeInterface $dateFinancement): static
    {
        $this->dateFinancement = $dateFinancement;

        return $this;
    }

    public function getStatutRemboursement(): ?string
    {
        return $this->statutRemboursement;
    }

    public function setStatutRemboursement(?string $statutRemboursement): static
    {
        $this->statutRemboursement = $statutRemboursement;

        return $this;
    }
}
