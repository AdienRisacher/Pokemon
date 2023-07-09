<?php

namespace App\Entity;

use App\Entity\Chasse;
use App\Repository\ChasseEmplacementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChasseEmplacementRepository::class)]
class ChasseEmplacement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'world', targetEntity: Chasse::class)]
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
     * @return Collection<int, Chasse>
     */
    public function getPokemonPossible(): Collection
    {
        return $this->PokemonPossible;
    }

    public function addPokemonPossible(Chasse $pokemonPossible): self
    {
        if (!$this->PokemonPossible->contains($pokemonPossible)) {
            $this->PokemonPossible[] = $pokemonPossible;
            $pokemonPossible->setWorld($this);
        }

        return $this;
    }

    public function removePokemonPossible(Chasse $pokemonPossible): self
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
