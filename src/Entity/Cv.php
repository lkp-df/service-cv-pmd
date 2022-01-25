<?php

namespace App\Entity;

use App\Repository\CvRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=ModelCv::class, mappedBy="cv")
     */
    private $modelCvs;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->modelCvs = new ArrayCollection();
    }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|ModelCv[]
     */
    public function getModelCvs(): Collection
    {
        return $this->modelCvs;
    }

    public function addModelCv(ModelCv $modelCv): self
    {
        if (!$this->modelCvs->contains($modelCv)) {
            $this->modelCvs[] = $modelCv;
            $modelCv->setCv($this);
        }

        return $this;
    }

    public function removeModelCv(ModelCv $modelCv): self
    {
        if ($this->modelCvs->removeElement($modelCv)) {
            // set the owning side to null (unless already changed)
            if ($modelCv->getCv() === $this) {
                $modelCv->setCv(null);
            }
        }

        return $this;
    }
}
