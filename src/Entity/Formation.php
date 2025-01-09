<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $structure = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $duree = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $commencement = null;

    #[ORM\ManyToOne]
    private ?Beneficiaire $beneficiaire = null;

    #[ORM\ManyToOne]
    private ?Specialite $specialisation = null;

    #[ORM\ManyToOne]
    private ?Diplome $diplome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStructure(): ?string
    {
        return $this->structure;
    }

    public function setStructure(?string $structure): static
    {
        $this->structure = $structure;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getCommencement(): ?\DateTimeInterface
    {
        return $this->commencement;
    }

    public function setCommencement(?\DateTimeInterface $commencement): static
    {
        $this->commencement = $commencement;

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

    public function getSpecialisation(): ?Specialite
    {
        return $this->specialisation;
    }

    public function setSpecialisation(?Specialite $specialisation): static
    {
        $this->specialisation = $specialisation;

        return $this;
    }

    public function getDiplome(): ?Diplome
    {
        return $this->diplome;
    }

    public function setDiplome(?Diplome $diplome): static
    {
        $this->diplome = $diplome;

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
}
