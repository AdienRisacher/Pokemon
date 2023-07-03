<?php

namespace App\Entity;

use App\Entity\Dresseur;
use App\Entity\HuntingWorld;
use App\Entity\PokemonType;
use App\Repository\PokemonCollectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonCollectionRepository::class)]
class PokemonCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $experience;

    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\Column(type: 'string', length: 255)]
    private $action;

    #[ORM\Column(type: 'time')]
    private $timeStartingAction;



    #[ORM\ManyToOne(targetEntity: PokemonType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $pokemon;

    #[ORM\ManyToOne(targetEntity: Dresseur::class, inversedBy: 'mesPokemons')]
    #[ORM\JoinColumn(nullable: false)]
    private $dresseur;

    #[ORM\Column(type: 'datetime')]
    private $timeActionChange;

    #[ORM\ManyToOne(targetEntity: HuntingWorld::class, inversedBy: 'PokemonPossible')]
    #[ORM\JoinColumn(nullable: false,columnDefinition: 'INT DEFAULT 6')]
    private $worldChass;

    #[ORM\Column(type: 'integer', options: ['default' => 1])]
    private $level;

    /**
     * @return mixed
     */
    public function getWorldChass()
    {
        return $this->worldChass;
    }

    /**
     * @param mixed $worldChass
     */
    public function setWorldChass($worldChass): void
    {
        $this->worldChass = $worldChass;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getTimeStartingAction(): ?\DateTimeInterface
    {
        return $this->timeStartingAction;
    }

    public function setTimeStartingAction(\DateTimeInterface $timeStartingAction): self
    {
        $this->timeStartingAction = $timeStartingAction;

        return $this;
    }

    public function getDresseur(): ?Dresseur
    {
        return $this->dresseur;
    }

    public function setDresseur(?Dresseur $dresseur): self
    {
        $this->dresseur = $dresseur;

        return $this;
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

    public function addPokmon(Dresseur $dresseur, PokemonType $pokemon): PokemonCollection
    {
        $pokemonCollection = new PokemonCollection();
        $pokemonCollection->setDresseur($dresseur);
        $pokemonCollection->setPokemon($pokemon);
        $pokemonCollection->setPrix(0);
        $pokemonCollection->setAction('normale');
        $pokemonCollection->setTimeStartingAction(new \DateTime());
        $pokemonCollection->setExperience(20);
        $pokemonCollection->setLevel(1);
        return $pokemonCollection;
    }



    public function getTimeRestant(): string
    {
        $timeRestant = $this->getTimeActionChange();
        $time = $timeRestant->diff(new \DateTime('now'));
        return $time->format('%I:%S');
    }

    public function getTimeActionChange(): ?\DateTimeInterface
    {
        return $this->timeActionChange;
    }

    public function setTimeActionChange(?\DateTimeInterface $timeActionChange): self
    {
        $this->timeActionChange = $timeActionChange;

        return $this;
    }

    public function updateExperiences(): self
    {
        $experience = rand(10, 30);
        $this->setExperience($this->getExperience() + $experience);
        return $this;
    }


    public function updateLevel(): self
    {
        $type_evolution = $this->getPokemon()->getTypeCourbeNiveau();


        $experience = 0;
        if($type_evolution == 'R'){
            $experience = pow( $this->getLevel(), 3)  * 0.8;
        }elseif($type_evolution == 'M'){
            $experience = pow( $this->getLevel(), 3) ;
        }elseif($type_evolution == 'P'){
            $experience = pow( $this->getLevel(), 3)  * 1.2 - 15 * pow( $this->getLevel(), 2) + 100 * $this->getLevel() - 140;
        }elseif ($type_evolution == 'L'){
            $experience = pow( $this->getLevel(), 3)  * 1.25;
        }
        if($this->getExperience() >= $experience){
            $this->setLevel($this->getLevel() + 1);
            $this->updateLevel();
        }
        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }






}
