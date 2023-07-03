<?php

namespace App\Controller;

use App\Entity\PokemonType;
use App\Form\PokemonTypeType;
use App\Repository\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

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
     */
    public function index(EntityRepository $entityRepository): Response
    {
        return $this->render('pokemon_type/index.html.twig', [
            'pokemon_types' => $entityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pokemon_type_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pokemonType = new PokemonType();
        $form = $this->createForm(PokemonTypeType::class, $pokemonType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pokemonType);
            $entityManager->flush();

            return $this->redirectToRoute('pokemon_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pokemon_type/new.html.twig', [
            'pokemon_type' => $pokemonType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="pokemon_type_show", methods={"GET"})
     */
    public function show(PokemonType $pokemonType): Response
    {
        return $this->render('pokemon_type/show.html.twig', [
            'pokemon_type' => $pokemonType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pokemon_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PokemonType $pokemonType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PokemonTypeType::class, $pokemonType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('pokemon_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pokemon_type/edit.html.twig', [
            'pokemon_type' => $pokemonType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="pokemon_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PokemonType $pokemonType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pokemonType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pokemonType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pokemon_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
