<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/lieu", name="lieu_")
 */
class LieuController extends AbstractController
{
    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lieu = new Lieu();
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lieu);
            $entityManager->flush();

            $this->addFlash('success', "Le lieu ".$lieu->getNom()." a bien été créé !");

            return $this->redirectToRoute('trajet_index');
        }

        return $this->render('lieu/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
