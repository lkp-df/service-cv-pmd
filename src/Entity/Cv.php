<?php

namespace App\Entity;

use App\Repository\CvRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CvRepository::class)
 */
class Cv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numCv;

    /**
     * @ORM\ManyToOne(targetEntity=UserForCv::class, inversedBy="curiclumVitae")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userForCv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCv(): ?int
    {
        return $this->numCv;
    }

    public function setNumCv(int $numCv): self
    {
        $this->numCv = $numCv;

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
