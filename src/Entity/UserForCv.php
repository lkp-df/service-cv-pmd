<?php

namespace App\Entity;

use App\Repository\UserForCvRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserForCvRepository::class)
 */
class UserForCv
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poste_recherche_occupe;

    /**
     * @ORM\OneToMany(targetEntity=Logiciel::class, mappedBy="userForCv")
     */
    private $logiciels;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="userForCv")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=CentreInteret::class, mappedBy="userForCv")
     */
    private $centreInteret;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="userForCv")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=Langue::class, mappedBy="userForCv")
     */
    private $langues;

    /**
     * @ORM\OneToMany(targetEntity=ExperienceProfessionnelle::class, mappedBy="userForCv")
     */
    private $experiences;

    /**
     * @ORM\OneToMany(targetEntity=Competence::class, mappedBy="userForCv")
     */
    private $competences;

    /**
     * @ORM\OneToMany(targetEntity=Profil::class, mappedBy="userForCv")
     */
    private $profils;

    /**
     * @ORM\OneToMany(targetEntity=Cv::class, mappedBy="userForCv")
     */
    private $curiclumVitae;

    public function __construct()
    {
        $this->logiciels = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->centreInteret = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->langues = new ArrayCollection();
        $this->experiences = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->profils = new ArrayCollection();
        $this->curiclumVitae = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getPosteRechercheOccupe(): ?string
    {
        return $this->poste_recherche_occupe;
    }

    public function setPosteRechercheOccupe(?string $poste_recherche_occupe): self
    {
        $this->poste_recherche_occupe = $poste_recherche_occupe;

        return $this;
    }

    /**
     * @return Collection|Logiciel[]
     */
    public function getLogiciels(): Collection
    {
        return $this->logiciels;
    }

    public function addLogiciel(Logiciel $logiciel): self
    {
        if (!$this->logiciels->contains($logiciel)) {
            $this->logiciels[] = $logiciel;
            $logiciel->setUserForCv($this);
        }

        return $this;
    }

    public function removeLogiciel(Logiciel $logiciel): self
    {
        if ($this->logiciels->removeElement($logiciel)) {
            // set the owning side to null (unless already changed)
            if ($logiciel->getUserForCv() === $this) {
                $logiciel->setUserForCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setUserForCv($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getUserForCv() === $this) {
                $contact->setUserForCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CentreInteret[]
     */
    public function getCentreInteret(): Collection
    {
        return $this->centreInteret;
    }

    public function addCentreInteret(CentreInteret $centreInteret): self
    {
        if (!$this->centreInteret->contains($centreInteret)) {
            $this->centreInteret[] = $centreInteret;
            $centreInteret->setUserForCv($this);
        }

        return $this;
    }

    public function removeCentreInteret(CentreInteret $centreInteret): self
    {
        if ($this->centreInteret->removeElement($centreInteret)) {
            // set the owning side to null (unless already changed)
            if ($centreInteret->getUserForCv() === $this) {
                $centreInteret->setUserForCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setUserForCv($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getUserForCv() === $this) {
                $formation->setUserForCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Langue[]
     */
    public function getLangues(): Collection
    {
        return $this->langues;
    }

    public function addLangue(Langue $langue): self
    {
        if (!$this->langues->contains($langue)) {
            $this->langues[] = $langue;
            $langue->setUserForCv($this);
        }

        return $this;
    }

    public function removeLangue(Langue $langue): self
    {
        if ($this->langues->removeElement($langue)) {
            // set the owning side to null (unless already changed)
            if ($langue->getUserForCv() === $this) {
                $langue->setUserForCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExperienceProfessionnelle[]
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(ExperienceProfessionnelle $experience): self
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences[] = $experience;
            $experience->setUserForCv($this);
        }

        return $this;
    }

    public function removeExperience(ExperienceProfessionnelle $experience): self
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getUserForCv() === $this) {
                $experience->setUserForCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->setUserForCv($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getUserForCv() === $this) {
                $competence->setUserForCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Profil[]
     */
    public function getProfils(): Collection
    {
        return $this->profils;
    }

    public function addProfil(Profil $profil): self
    {
        if (!$this->profils->contains($profil)) {
            $this->profils[] = $profil;
            $profil->setUserForCv($this);
        }

        return $this;
    }

    public function removeProfil(Profil $profil): self
    {
        if ($this->profils->removeElement($profil)) {
            // set the owning side to null (unless already changed)
            if ($profil->getUserForCv() === $this) {
                $profil->setUserForCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cv[]
     */
    public function getCuriclumVitae(): Collection
    {
        return $this->curiclumVitae;
    }

    public function addCuriclumVitae(Cv $curiclumVitae): self
    {
        if (!$this->curiclumVitae->contains($curiclumVitae)) {
            $this->curiclumVitae[] = $curiclumVitae;
            $curiclumVitae->setUserForCv($this);
        }

        return $this;
    }

    public function removeCuriclumVitae(Cv $curiclumVitae): self
    {
        if ($this->curiclumVitae->removeElement($curiclumVitae)) {
            // set the owning side to null (unless already changed)
            if ($curiclumVitae->getUserForCv() === $this) {
                $curiclumVitae->setUserForCv(null);
            }
        }

        return $this;
    }
}
