<?php

namespace App\Entity;

use App\Entity\ChasseEmplacement;
use App\Entity\PokemonType;
use App\Repository\ChasseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChasseRepository::class)]
class Chasse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PokemonType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $pokemon;

    #[ORM\ManyToOne(targetEntity: ChasseEmplacement::class, inversedBy: 'PokemonPossible')]
    #[ORM\JoinColumn(nullable: false)]
    private $world;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPokemon(): ?PokemonType
    {
        return $this->pokemon;
    }

    public function setPokemon(?PokemonType $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getWorld(): ?ChasseEmplacement
    {
        return $this->world;
    }

    public function setWorld(?ChasseEmplacement $world): self
    {
        $this->world = $world;

        return $this;
    }
}
