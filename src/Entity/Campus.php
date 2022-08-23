<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: participant::class)]
    private Collection $campus;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: sortie::class)]
    private Collection $campusOrganisateur;

    public function __construct()
    {
        $this->campus = new ArrayCollection();
        $this->campusOrganisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, participant>
     */
    public function getCampus(): Collection
    {
        return $this->campus;
    }

    public function addCampus(participant $campus): self
    {
        if (!$this->campus->contains($campus)) {
            $this->campus->add($campus);
            $campus->setCampus($this);
        }

        return $this;
    }

    public function removeCampus(participant $campus): self
    {
        if ($this->campus->removeElement($campus)) {
            // set the owning side to null (unless already changed)
            if ($campus->getCampus() === $this) {
                $campus->setCampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, sortie>
     */
    public function getCampusOrganisateur(): Collection
    {
        return $this->campusOrganisateur;
    }

    public function addCampusOrganisateur(sortie $campusOrganisateur): self
    {
        if (!$this->campusOrganisateur->contains($campusOrganisateur)) {
            $this->campusOrganisateur->add($campusOrganisateur);
            $campusOrganisateur->setCampus($this);
        }

        return $this;
    }

    public function removeCampusOrganisateur(sortie $campusOrganisateur): self
    {
        if ($this->campusOrganisateur->removeElement($campusOrganisateur)) {
            // set the owning side to null (unless already changed)
            if ($campusOrganisateur->getCampus() === $this) {
                $campusOrganisateur->setCampus(null);
            }
        }

        return $this;
    }
}
