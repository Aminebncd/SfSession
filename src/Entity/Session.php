<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule_session = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    private ?int $nombrePlaces = null;

    #[ORM\ManyToOne(inversedBy: 'session')]
    private ?Formation $formation = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Formateur $formateur = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'sessions')]
    private Collection $inscrits;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?User $createur = null;

    #[ORM\OneToMany(targetEntity: Programme::class, mappedBy: 'session')]
    private Collection $programmes;

    public function __construct()
    {
        $this->inscrits = new ArrayCollection();
        $this->programmes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleSession(): ?string
    {
        return $this->intitule_session;
    }

    public function setIntituleSession(string $intitule_session): static
    {
        $this->intitule_session = $intitule_session;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function getDateDebutFR(): ?string
    {
        $this->dateDebutFR = $this->dateDebut->format('d.m.Y');
        return $this->dateDebutFR;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function getDateFinFR(): ?string
    {
        $this->dateFinFR = $this->dateFin->format('d.m.Y');
        return $this->dateFinFR;
    }

    public function getDureeSession(): ?int
    {
        $this->dureeSession = strtotime($this->dateFinFR) - strtotime($this->dateDebutFR);
        return round($this->dureeSession / (60 * 60 * 24));
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNombrePlaces(): ?int
    {
        return $this->nombrePlaces;
    }

    public function setNombrePlaces(int $nombrePlaces): static
    {
        $this->nombrePlaces = $nombrePlaces;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): static
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getInscrits(): Collection
    {
        return $this->inscrits;
    }

    public function addInscrit(User $inscrit): static
    {
        if (!$this->inscrits->contains($inscrit)) {
            $this->inscrits->add($inscrit);
        }

        return $this;
    }

    public function removeInscrit(User $inscrit): static
    {
        $this->inscrits->removeElement($inscrit);

        return $this;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): static
    {
        $this->createur = $createur;

        return $this;
    }

    public function __tostring(){
        return $this->intitule_session;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes->add($programme);
            $programme->setSession($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getSession() === $this) {
                $programme->setSession(null);
            }
        }

        return $this;
    }
}
