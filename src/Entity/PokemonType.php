<?php

namespace App\Entity;

use App\Controller\ElementaryTypeController;
use App\Repository\PokemonTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonTypeRepository::class)]
class PokemonType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'boolean')]
    private $evolution;

    #[ORM\Column(type: 'boolean')]
    private $starter;


    #[ORM\Column(type: 'string', length: 1)]
    private $typeCourbeNiveau;

    #[ORM\ManyToOne(targetEntity: ElementaryType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $type1;

    #[ORM\ManyToOne(targetEntity: ElementaryType::class)]
    private $type2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function isEvolution(): ?bool
    {
        return $this->evolution;
    }

    public function setEvolution(bool $evolution): self
    {
        $this->evolution = $evolution;

        return $this;
    }

    public function isStarter(): ?bool
    {
        return $this->starter;
    }

    public function setStarter(bool $starter): self
    {
        $this->starter = $starter;

        return $this;
    }

    public function getTypeCourbeNiveau(): ?string
    {
        return $this->typeCourbeNiveau;
    }

    public function setTypeCourbeNiveau(string $typeCourbeNiveau): self
    {
        $this->typeCourbeNiveau = $typeCourbeNiveau;

        return $this;
    }

    public function getType1(): ?ElementaryType
    {
        return $this->type1;
    }

    public function setType1(?ElementaryType $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?ElementaryType
    {
        return $this->type2;
    }

    public function setType2(?ElementaryType $type): self
    {
        $this->type2 = $type;

        return $this;
    }


}
