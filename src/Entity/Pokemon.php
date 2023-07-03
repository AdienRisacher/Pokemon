<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $evolution = null;

    #[ORM\Column]
    private ?int $starter = null;

    #[ORM\Column(length: 255)]
    private ?string $type_courbe_niveau = null;

    #[ORM\Column(nullable: true)]
    private ?int $type_2 = null;

    #[ORM\Column]
    private ?int $type_1 = null;

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

    public function getEvolution(): ?int
    {
        return $this->evolution;
    }

    public function setEvolution(int $evolution): static
    {
        $this->evolution = $evolution;

        return $this;
    }

    public function getStarter(): ?int
    {
        return $this->starter;
    }

    public function setStarter(int $starter): static
    {
        $this->starter = $starter;

        return $this;
    }

    public function getTypeCourbeNiveau(): ?string
    {
        return $this->type_courbe_niveau;
    }

    public function setTypeCourbeNiveau(string $type_courbe_niveau): static
    {
        $this->type_courbe_niveau = $type_courbe_niveau;

        return $this;
    }

    public function getType2(): ?int
    {
        return $this->type_2;
    }

    public function setType2(?int $type_2): static
    {
        $this->type_2 = $type_2;

        return $this;
    }

    public function getType1(): ?int
    {
        return $this->type_1;
    }

    public function setType1(int $type_1): static
    {
        $this->type_1 = $type_1;

        return $this;
    }
}
