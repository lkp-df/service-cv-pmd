<?php

namespace App\Controller\Admin;

use App\Entity\TypeAbonnement;
use App\Form\TypeAbonnementType;
use App\Repository\TypeAbonnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/type_abonnement")
 */
class TypeAbonnementController extends AbstractController
{
    /**
     * @Route("/", name="admin_type_abonnement_index", methods={"GET"})
     */
    public function index(TypeAbonnementRepository $typeAbonnementRepository): Response
    {
        return $this->render('admin/type_abonnement/index.html.twig', [
            'type_abonnements' => $typeAbonnementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_type_abonnement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeAbonnement = new TypeAbonnement();
        $form = $this->createForm(TypeAbonnementType::class, $typeAbonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeAbonnement);
            $entityManager->flush();

            return $this->redirectToRoute('admin_type_abonnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/type_abonnement/new.html.twig', [
            'type_abonnement' => $typeAbonnement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_type_abonnement_show", methods={"GET"})
     */
    public function show(TypeAbonnement $typeAbonnement): Response
    {
        return $this->render('admin/type_abonnement/show.html.twig', [
            'type_abonnement' => $typeAbonnement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_type_abonnement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeAbonnement $typeAbonnement): Response
    {
        //on va remplir le formulaire en fonction de l'abonnement
        $typeAbonnement->setDesignation($typeAbonnement->getDesignation())
            ->setMontant($typeAbonnement->getMontant())
            ->setNombreCv($typeAbonnement->getNombreCv());
        $form = $this->createForm(TypeAbonnementType::class, $typeAbonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_type_abonnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/type_abonnement/edit.html.twig', [
            'type_abonnement' => $typeAbonnement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_type_abonnement_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeAbonnement $typeAbonnement): Response
    {
        if ($this->isCsrfTokenValid('delete' . $typeAbonnement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeAbonnement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_type_abonnement_index', [], Response::HTTP_SEE_OTHER);
    }
}
