<?php

namespace App\Controller;

use App\Entity\PokemonType;
use App\Form\PokemonTypeType;
use App\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pokemons")
 */
class PokemonTypeController extends AbstractController
{
    /**
     * @Route("/", name="pokemon_type_index", methods={"GET"})
     * Display all Pokémon types
     *
     * @param EntityRepository $entityRepository
     * @return Response
     */
    public function index(EntityRepository $entityRepository): Response
    {
        // Retrieve all records from the PokemonType repository
        return $this->render('pokemon_type/index.html.twig', [
            'pokemon_types' => $entityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pokemon_type_new", methods={"GET","POST"})
     *
     * Create a new Pokémon type
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function new(Request $request,EntityManagerInterface $entityManager): Response
    {
        $pokemonType = new PokemonType();
        $form = $this->createForm(PokemonTypeType::class, $pokemonType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pokemonType);
            $entityManager->flush();

            return $this->redirectToRoute('pokemon_type_index');
        }

        return $this->render('pokemon_type/new.html.twig', [
            'pokemon_type' => $pokemonType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Display details of a specific Pokémon type
     *
     * @param int $id
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     *
     * @Route("/{id}", name="pokemon_type_show", methods={"GET"})
     */
    public function show(int $id, Request $request, ManagerRegistry $doctrine): Response
    {
        $pokemonType = $doctrine->getRepository(PokemonType::class)->findOneBy(['id' => $id]);
        return $this->render('pokemon_type/show.html.twig', [
            'pokemon_type' => $pokemonType,
        ]);
    }

    /**
     * Edit a Pokémon type
     *
     * @param Request $request
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @param EntityManagerInterface $entityManager
     * @return Response
     *
     * @Route("/{id}/edit", name="pokemon_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,int $id, ManagerRegistry $doctrine,EntityManagerInterface $entityManager): Response
    {
        $pokemonType = $doctrine->getRepository(PokemonType::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(PokemonTypeType::class, $pokemonType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($pokemonType);
            $entityManager->flush();


            return $this->redirectToRoute('pokemon_type_index');
        }

        return $this->render('pokemon_type/edit.html.twig', [
            'pokemon_type' => $pokemonType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete a Pokémon type
     *
     * @param Request $request
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route("/{id}", name="pokemon_type_delete")
     */
    public function delete(Request $request, int $id, ManagerRegistry $doctrine,EntityManagerInterface $entityManager): Response
    {
        // Find the Pokémon type by its ID
        $pokemonType = $doctrine->getRepository(PokemonType::class)->findOneBy(['id' => $id]);
        if ($this->isCsrfTokenValid('delete'.$pokemonType->getId(), $request->request->get('_token'))) {
            // Remove the Pokémon type from the database
            $entityManager->remove($pokemonType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pokemon_type_index');
    }
}
