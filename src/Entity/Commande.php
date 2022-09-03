<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    const STATE = [
        'En attente'=>'En attente',
        'En cour'=>'En cour'
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $paymentDue;

    /**
     * @ORM\Column(type="integer")
     */
    private $items_total;

    /**
     * @ORM\Column(type="integer")
     */
    private $adjustments_total;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=CommandeItem::class, mappedBy="commande", orphanRemoval=true, cascade={"persist"})
     */
    private $commandeItems;

    public function __construct()
    {
        $this->commandeItems = new ArrayCollection();
    }

    public function getFacture(){
        return 'Facture N° '.$this->getNumber().' - Cv PMD';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

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

    public function getPaymentDue(): ?\DateTimeInterface
    {
        return $this->paymentDue;
    }

    public function setPaymentDue(\DateTimeInterface $paymentDue): self
    {
        $this->paymentDue = $paymentDue;

        return $this;
    }

    public function getItemsTotal(): ?int
    {
        return $this->items_total;
    }

    public function setItemsTotal(int $items_total): self
    {
        $this->items_total = $items_total;

        return $this;
    }

    public function getAdjustmentsTotal(): ?int
    {
        return $this->adjustments_total;
    }

    public function setAdjustmentsTotal(int $adjustments_total): self
    {
        $this->adjustments_total = $adjustments_total;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|CommandeItem[]
     */
    public function getCommandeItems(): Collection
    {
        return $this->commandeItems;
    }

    public function addCommandeItem(CommandeItem $commandeItem): self
    {
        if (!$this->commandeItems->contains($commandeItem)) {
            $this->commandeItems[] = $commandeItem;
            $commandeItem->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeItem(CommandeItem $commandeItem): self
    {
        if ($this->commandeItems->removeElement($commandeItem)) {
            // set the owning side to null (unless already changed)
            if ($commandeItem->getCommande() === $this) {
                $commandeItem->setCommande(null);
            }
        }

        return $this;
    }
}
