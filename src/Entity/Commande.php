<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $id_client = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    #[ORM\Column]
    private ?bool $etat_commande = null;

    /**
     * @var Collection<int, OrdProduit>
     */
    #[ORM\OneToMany(targetEntity: OrdProduit::class, mappedBy: 'id_commande')]
    private Collection $ordProduits;

    public function __construct()
    {
        $this->ordProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?Utilisateur
    {
        return $this->id_client;
    }

    public function setIdClient(?Utilisateur $id_client): static
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): static
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function isEtatCommande(): ?bool
    {
        return $this->etat_commande;
    }

    public function setEtatCommande(bool $etat_commande): static
    {
        $this->etat_commande = $etat_commande;

        return $this;
    }

    /**
     * @return Collection<int, OrdProduit>
     */
    public function getOrdProduits(): Collection
    {
        return $this->ordProduits;
    }

    public function addOrdProduit(OrdProduit $ordProduit): static
    {
        if (!$this->ordProduits->contains($ordProduit)) {
            $this->ordProduits->add($ordProduit);
            $ordProduit->setIdCommande($this);
        }

        return $this;
    }

    public function removeOrdProduit(OrdProduit $ordProduit): static
    {
        if ($this->ordProduits->removeElement($ordProduit)) {
            // set the owning side to null (unless already changed)
            if ($ordProduit->getIdCommande() === $this) {
                $ordProduit->setIdCommande(null);
            }
        }

        return $this;
    }
}
