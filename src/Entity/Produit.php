<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column]
    private ?int $vendu = null;

    #[ORM\Column]
    private ?bool $is_drink = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getVendu(): ?int
    {
        return $this->vendu;
    }

    public function setVendu(int $vendu): static
    {
        $this->vendu = $vendu;

        return $this;
    }

    public function get_is_drink(): ?bool
    {
        return $this->is_drink;
    }

    public function set_is_Drink(bool $is_drink): static
    {
        $this->is_drink = $is_drink;

        return $this;
    }
}
