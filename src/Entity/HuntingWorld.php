<?php

namespace App\Entity;

use App\Entity\Hunting;
use App\Repository\HuntingWorldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HuntingWorldRepository::class)]
class HuntingWorld
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'world', targetEntity: Hunting::class)]
    private $PokemonPossible;

    public function __construct()
    {
        $this->PokemonPossible = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Hunting>
     */
    public function getPokemonPossible(): Collection
    {
        return $this->PokemonPossible;
    }

    public function addPokemonPossible(Hunting $pokemonPossible): self
    {
        if (!$this->PokemonPossible->contains($pokemonPossible)) {
            $this->PokemonPossible[] = $pokemonPossible;
            $pokemonPossible->setWorld($this);
        }

        return $this;
    }

    public function removePokemonPossible(Hunting $pokemonPossible): self
    {
        if ($this->PokemonPossible->removeElement($pokemonPossible)) {
            // set the owning side to null (unless already changed)
            if ($pokemonPossible->getWorld() === $this) {
                $pokemonPossible->setWorld(null);
            }
        }

        return $this;
    }



}
