<?php

namespace App\Entity;

use App\Repository\TacheEffectuerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TacheEffectuerRepository::class)
 */
class TacheEffectuer
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
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=ExperienceProfessionnelle::class, inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $experienceProfessionnelle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExperienceProfessionnelle(): ?ExperienceProfessionnelle
    {
        return $this->experienceProfessionnelle;
    }

    public function setExperienceProfessionnelle(?ExperienceProfessionnelle $experienceProfessionnelle): self
    {
        $this->experienceProfessionnelle = $experienceProfessionnelle;

        return $this;
    }
}
