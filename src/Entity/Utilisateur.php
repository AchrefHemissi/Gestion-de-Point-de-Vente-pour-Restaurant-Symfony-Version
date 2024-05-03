<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    public ?string $email=null;

    #[ORM\Column(length: 255)]
    public ?string $pass=null;

    #[ORM\Column]
    private ?bool $is_banned = null;

    #[ORM\Column]
    private ?bool $is_admin = null;

    #[ORM\Column]
    private ?int $num_tel = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'id_client')]
    private Collection $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {

        return $this->email;

    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): static
    {
        $this->pass = $pass;
        return $this;
    }

    public function get_is_Banned(): ?bool
    {
        return $this->is_banned;
    }

    public function set_is_Banned(bool $is_banned): static
    {
        $this->is_banned = $is_banned;

        return $this;
    }

    public function get_is_Admin(): ?bool
    {
        return $this->is_admin;
    }

    public function set_is_Admin(bool $is_admin): static
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(int $num_tel): static
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setIdClient($this);
        }

        return $this;
    }

}
