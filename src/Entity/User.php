<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *  message = "The email '{{ value }}' is not a valid email;"
     * )
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity=Personne::class, cascade={"persist", "remove"})
     */
    private $personne;

    /**
     * @ORM\OneToMany(targetEntity=ModelCv::class, mappedBy="createur")
     */
    private $modeleCv;

    /**
     * @ORM\OneToMany(targetEntity=Cv::class, mappedBy="user")
     */
    private $mesCv;

    public function __construct()
    {
        $this->modeleCv = new ArrayCollection();
        $this->mesCv = new ArrayCollection();
    }

    

    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * @return Collection|ModelCv[]
     */
    public function getModeleCv(): Collection
    {
        return $this->modeleCv;
    }

    public function addModeleCv(ModelCv $modeleCv): self
    {
        if (!$this->modeleCv->contains($modeleCv)) {
            $this->modeleCv[] = $modeleCv;
            $modeleCv->setCreateur($this);
        }

        return $this;
    }

    public function removeModeleCv(ModelCv $modeleCv): self
    {
        if ($this->modeleCv->removeElement($modeleCv)) {
            // set the owning side to null (unless already changed)
            if ($modeleCv->getCreateur() === $this) {
                $modeleCv->setCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cv[]
     */
    public function getMesCv(): Collection
    {
        return $this->mesCv;
    }

    public function addMesCv(Cv $mesCv): self
    {
        if (!$this->mesCv->contains($mesCv)) {
            $this->mesCv[] = $mesCv;
            $mesCv->setUser($this);
        }

        return $this;
    }

    public function removeMesCv(Cv $mesCv): self
    {
        if ($this->mesCv->removeElement($mesCv)) {
            // set the owning side to null (unless already changed)
            if ($mesCv->getUser() === $this) {
                $mesCv->setUser(null);
            }
        }

        return $this;
    }
    
}
