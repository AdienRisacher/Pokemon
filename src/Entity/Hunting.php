<?php

namespace App\Entity;

use App\Entity\HuntingWorld;
use App\Entity\PokemonType;
use App\Repository\HuntingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HuntingRepository::class)]
class Hunting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PokemonType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $pokemon;

    #[ORM\ManyToOne(targetEntity: HuntingWorld::class, inversedBy: 'PokemonPossible')]
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

    public function getWorld(): ?HuntingWorld
    {
        return $this->world;
    }

    public function setWorld(?HuntingWorld $world): self
    {
        $this->world = $world;

        return $this;
    }
}
