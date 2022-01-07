<?php

namespace App\Entity;

use App\Repository\LangueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LangueRepository::class)
 */
class Langue
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
    private $designation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveau_pourcent;

    /**
     * @ORM\ManyToOne(targetEntity=UserForCv::class, inversedBy="langues")
     */
    private $userForCv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getNiveauPourcent(): ?int
    {
        return $this->niveau_pourcent;
    }

    public function setNiveauPourcent(?int $niveau_pourcent): self
    {
        $this->niveau_pourcent = $niveau_pourcent;

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
}
