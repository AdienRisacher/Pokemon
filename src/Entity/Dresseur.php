<?php

namespace App\Entity;

use App\Entity\PokemonCollection;
use App\Repository\DresseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DresseurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Dresseur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\Email (message: "Votre email n'est pas valide")]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min: 4, minMessage: "Votre mot de passe doit faire au moins 8 caractères")]
    private $password;

    #[ORM\Column(type: 'integer')]
    private $coins;

    #[ORM\Column(type: 'integer')]
    private $type;

    #[Assert\EqualTo(propertyPath: "password", message: "Vous n'avez pas tapé le même mot de passe")]
    private $repeat_password;

    #[ORM\OneToMany(mappedBy: 'dresseur', targetEntity: PokemonCollection::class)]
    private $mesPokemons;

    #[ORM\Column(type: 'boolean')]
    private $avoirPremierPok;



    public function __construct()
    {
        $this->mesPokomons = new ArrayCollection();
    }


    public function getRepeatPassword():?string
    {
        return $this->repeat_password;
    }

    public function setRepeatPassword($repeat_password): self
    {
        $this->repeat_password = $repeat_password;
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCoins(): ?int
    {
        return $this->coins;
    }

    public function setCoins(int $coins): self
    {
        $this->coins = $coins;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function addPok(PokemonCollection $pok): self
    {
        if (!$this->mesPokemons->contains($pok)) {
            $this->mesPokomons[] = $pok;
            $pok->setDresseur($this);
        }

        return $this;
    }

    public function removePok(PokemonCollection $pok): self
    {
        if ($this->mesPokomons->removeElement($pok)) {
            // set the owning side to null (unless already changed)
            if ($pok->getDresseur() === $this) {
                $pok->setDresseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PokemonCollection>
     */
    public function getMesPokemons(): Collection
    {
        return $this->mesPokemons;
    }

    public function addMesPokemon(PokemonCollection $mesPokemon): self
    {
        if (!$this->mesPokemons->contains($mesPokemon)) {
            $this->mesPokemons[] = $mesPokemon;
            $mesPokemon->setDresseur($this);
        }

        return $this;
    }

    public function removeMesPokemon(PokemonCollection $mesPokemon): self
    {
        if ($this->mesPokemons->removeElement($mesPokemon)) {
            // set the owning side to null (unless already changed)
            if ($mesPokemon->getDresseur() === $this) {
                $mesPokemon->setDresseur(null);
            }
        }

        return $this;
    }

    public function getAvoirPremierPok(): ?bool
    {
        return $this->avoirPremierPok;
    }

    public function setAvoirPremierPok(bool $avoirPremierPok): self
    {
        $this->avoirPremierPok = $avoirPremierPok;

        return $this;
    }

}
