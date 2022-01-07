<?php

namespace App\Entity;

use App\Repository\ExperienceProfessionnelleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExperienceProfessionnelleRepository::class)
 */
class ExperienceProfessionnelle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomEntreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $posteOccupe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $anneeOccupation;

    /**
     * @ORM\ManyToOne(targetEntity=UserForCv::class, inversedBy="experiences")
     */
    private $userForCv;

    /**
     * @ORM\OneToMany(targetEntity=TacheEffectuer::class, mappedBy="experienceProfessionnelle")
     */
    private $taches;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getPosteOccupe(): ?string
    {
        return $this->posteOccupe;
    }

    public function setPosteOccupe(string $posteOccupe): self
    {
        $this->posteOccupe = $posteOccupe;

        return $this;
    }

    public function getAnneeOccupation(): ?string
    {
        return $this->anneeOccupation;
    }

    public function setAnneeOccupation(string $anneeOccupation): self
    {
        $this->anneeOccupation = $anneeOccupation;

        return $this;
    }

    public function getUserForCv(): ?UserForCv
    {
        return $this->userForCv;
    }

    public function setUserForCv(?UserForCv $userForCv): self
    {
        $this->userForCv = $userForCv;

        return $this;
    }

    /**
     * @return Collection|TacheEffectuer[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(TacheEffectuer $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->setExperienceProfessionnelle($this);
        }

        return $this;
    }

    public function removeTach(TacheEffectuer $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getExperienceProfessionnelle() === $this) {
                $tach->setExperienceProfessionnelle(null);
            }
        }

        return $this;
    }
}
