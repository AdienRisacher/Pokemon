<?php

namespace App\Controller;

use App\Entity\ElementaryType;
use App\Form\ElementaryTypeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/element/type")
 */
class ElementaryTypeController extends AbstractController
{
    /**
     * @Route("/", name="typeElementIndex", methods={"GET"})
     */
    // Retrieve all records of the ElementaryType entity from the database using the Doctrine
    // entity manager, then pass them to the view to display them.
    public function index(): Response
    {
        $typeElement = $this->getDoctrine()
            ->getRepository(ElementaryType::class)
            ->findAll();

        return $this->render('type_element/index.html.twig', [
            'typeElement' => $typeElement,
        ]);
    }

    /**
     * @Route("/new", name="typeElementNew", methods={"GET","POST"})
     */
    // Method called when trying to use a new instance of ElementaryType
    public function new(Request $request): Response
    {
        $typeElement = new ElementaryType();
        $form = $this->createForm(ElementaryTypeType::class, $typeElement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeElement);
            $entityManager->flush();

            return $this->redirectToRoute('typeElementIndex');
        }

        return $this->render('typeElement/new.html.twig', [
            'typeElement' => $typeElement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="typeElementShow", methods={"GET"})
     */

    // Show details of an elementaryType object
    public function show(ElementaryType $typeElement): Response
    {
        return $this->render('typeElement/show.html.twig', [
            'typeElement' => $typeElement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="typeElementEdit", methods={"GET","POST"})
     */

    // Changing an elementaryType object from a form
    public function edit(Request $request, ElementaryType $typeElement): Response
    {
        $form = $this->createForm(ElementaryTypeType::class, $typeElement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typeElementIndex');
        }

        return $this->render('typeElement/edit.html.twig', [
            'typeElement' => $typeElement,
            'form' => $form->createView(),
        ]);
    }

    // Delete an elementaryType Object from a form
    /**
     * @Route("/{id}", name="typeElementDelete", methods={"DELETE"})
     */
    public function delete(Request $request, ElementaryType $typeElement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeElement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeElement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('typeElementIndex');
    }
}
