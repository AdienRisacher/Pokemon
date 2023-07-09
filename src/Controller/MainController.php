<?php

namespace App\Controller;

use App\Entity\ChasseEmplacement;
use App\Entity\PokemonCollection;

use App\Entity\PokemonType;
use App\Repository\EntityRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    // redirect to index
    #[Route('/', name: 'index')]
    public function index()
    {
        return $this->render('index.html.twig');
    }

    // access to the user profile
    #[Route('/profile', name: 'profile')]
    public function getProfile(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        // if there's no user, redirect to the login page
        $user = $this->getUser();
        if($user == null)
        {
            return $this->redirectToRoute('app_login');
        }

        if ($user->getType() == 0)
        {
            return $this->redirectToRoute('homepage');
        }

        // if the user has already a pokemon, get market infos, update the level of each pokemon, show the view

        if ($user->getAvoirPremierPok()) {
            $market = $doctrine->getRepository(PokemonCollection::class)->findBy(['action' => 'market']);

            $all_pokemon = $user->getMesPokemons();

            foreach ($all_pokemon as $pokemon) {
                if ($pokemon->getTimeActionChange() != null) {

                    $tempsRestant = $pokemon->getTimeActionChange()->add(new DateInterval('PT1H'));
                    $temps = new DateTime('now');
                    if ($tempsRestant < $temps) {
                        if ($pokemon->getAction() == 'dev') {
                            $pokemon->setAction('normale');
                            $pokemon->setTimeActionChange(new DateTime('now'));
                            $entityManager->persist($pokemon);
                            $entityManager->flush();
                        } elseif ($pokemon->getAction() == 'chasse') {

                            $pokemon->setAction('normale');
                            $pokemon->setTimeActionChange(new DateTime('now'));
                            $entityManager->persist($pokemon);
                            $entityManager->flush();
                        }
                    }
                }

            }

            foreach ($user->getMesPokemons() as $pokemon) {
                $pokemon->updateLevel();
                $entityManager->persist($pokemon);
                $entityManager->flush();
            }


            return $this->render('profil.html.twig', [
                'user' => $user,
                'market' => $market
            ]);
        }

        return $this->render('starter.html.twig');
    }

    #[Route('/FirstPokemon/{pokname}', name: 'FirstPokemon')]
    public function getFirstPokemon(string $pokname, Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();

        if ($user->getAvoirPremierPok()) {
            $market = $doctrine->getRepository(PokemonCollection::class)->findBy(['action' => 'market']);
            return $this->render('profil.html.twig', [
                'user' => $user,
                'market' => $market
            ]);
        }

        $pokemon = $doctrine->getRepository(PokemonType::class)->findOneBy(['nom' => $pokname]);


        $pokemoncollection = new PokemonCollection();
        $pokemoncollection = $pokemoncollection->addPokmon($user, $pokemon);
        $world = $doctrine->getRepository(ChasseEmplacement::class)->findOneBy(['id' => 6]);
        $pokemoncollection->setWorldChass($world);


        $user->setAvoirPremierPok(true);
        $user->addMesPokemon($pokemoncollection);
        $entityManager->persist($pokemoncollection);
        $entityManager->flush();

        $user = $this->getUser();
        $market = $doctrine->getRepository(PokemonCollection::class)->findBy(['action' => 'market']);
        return $this->render('profil.html.twig', [
            'user' => $user,
            'market' => $market
        ]);
    }

    #[Route('/Entrainer/{id}', name: 'Entrainer')]
    public function entrainerPokemon(int $id, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $pokemonCollection = $doctrine->getRepository(PokemonCollection::class)->findOneBy(['id' => $id]);
        $pokemonCollection->updateExperiences();
        $pokemonCollection->setAction('dev');
        $pokemonCollection->setTimeActionChange(new \DateTime('now'));
        $entityManager->persist($pokemonCollection);
        $entityManager->flush();
        return $this->redirectToRoute('profile');
    }

    #[Route('/AcheterPokemon/{id}', name: 'AcheterPokemon')]
    public function acheterPokemon(int $id, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $pokemonCollection = $doctrine->getRepository(PokemonCollection::class)->findOneBy(['id' => $id]);

        $AncienDresseur = $pokemonCollection->getDresseur();
        $user = $this->getUser();

        $AncienDresseur->setCoins($AncienDresseur->getCoins() + $pokemonCollection->getPrix());
        $user->setCoins($user->getCoins() - $pokemonCollection->getPrix());
        $pokemonCollection->setDresseur($user);
        $pokemonCollection->setAction('normale');
        $pokemonCollection->setTimeActionChange(new \DateTime());
        $entityManager->persist($pokemonCollection);
        $entityManager->persist($AncienDresseur);
        $entityManager->persist($user);
        $entityManager->flush();
        $entityManager->flush();
        return $this->redirectToRoute('profile');
    }


    #[Route('/VendrePokemon/{id}', name: 'VendrePokemon')]
    public function vendrePokemon(int $id, Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $prix = (int)$request->request->get('prix');
        $pokemonCollection = $doctrine->getRepository(PokemonCollection::class)->findOneBy(['id' => $id]);
        $pokemonCollection->setAction('market');
        $pokemonCollection->setPrix($prix);
        $pokemonCollection->setTimeActionChange(new \DateTime());
        $entityManager->persist($pokemonCollection);
        $entityManager->flush();
        return $this->redirectToRoute('profile');
    }

    #[Route('/retirerMarche/{id}', name: 'retireMarche')]
    public function retirerMarche(int $id, Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $pokemonCollection = $doctrine->getRepository(PokemonCollection::class)->findOneBy(['id' => $id]);
        $pokemonCollection->setAction('normale');
        $pokemonCollection->setTimeActionChange(new \DateTime());
        $entityManager->persist($pokemonCollection);
        $entityManager->flush();
        return $this->redirectToRoute('profile');
    }


    #[Route('/Chasser/{libelle}', name: 'Chasser')]
    public function Chasser(string $libelle, Request $request,ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $world = $doctrine->getRepository(ChasseEmplacement::class)->findOneBy(['libelle' => $libelle]);
        $id = (int)$request->request->get('pokemon');
        $pokemonCollection = $doctrine->getRepository(PokemonCollection::class)->findOneBy(['id' => $id]);
        $pokemonCollection->setAction('chasse');
        $pokemonCollection->setTimeActionChange(new \DateTime());
        $pokemonCollection->setWorldChass($world);

        $user = $this->getUser();
        $all_pokemon = $world->getPokemonPossible()->getValues();
        if ($all_pokemon) {
            $poki = array_rand($all_pokemon, 1);
            $pokemoncollection = new PokemonCollection();
            $pokemoncollection = $pokemoncollection->addPokmon($user, $all_pokemon[$poki]->getPokemon());
            $huntingWorld = $doctrine->getRepository(ChasseEmplacement::class)->findOneBy(['id' => 6]);
            $pokemoncollection->setWorldChass($huntingWorld);
            $entityManager->persist($pokemoncollection);
            $entityManager->flush();
        }


        $entityManager->persist($pokemonCollection);
        $entityManager->flush();
        return $this->redirectToRoute('profile');
    }


    #[Route('/homepage', name: 'homepage')]
    public function homepage(EntityRepository $entityRepository,ManagerRegistry $doctrine)
    {
        $pokemons = $doctrine->getRepository(PokemonType::class)->findAll();
        $nb = sizeof($pokemons);
        //$nbEvo = $doctrine->getRepository(PokemonType::class)->findBy(['evolution' => true]);


        $nbEvo = $entityRepository->getNbEvo();

        $stats = $entityRepository->getStatsByType();
        $stats = $stats->fetchAll();

        return $this->render('main/index.html.twig', [
            'pokemons' => $pokemons,
            'nb' => $nb,
            'stats' => $stats,
            'nbEvo' => $nbEvo
        ]);
    }

}
