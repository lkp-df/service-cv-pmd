<?php

namespace App\Controller\Admin;

use App\Entity\ModelCv;
use App\Form\ModelCvType;
use App\Repository\ModelCvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/model")
 */
class ModelCvController extends AbstractController
{
    /**
     * @Route("/", name="model_index", methods={"GET"})
     */
    public function index(ModelCvRepository $modelCvRepository): Response
    {
        return $this->render('admin/model_cv/index.html.twig', [
            'model_cvs' => $modelCvRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="model_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $modelCv = new ModelCv();
        $form = $this->createForm(ModelCvType::class, $modelCv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($modelCv);
            $entityManager->flush();

            return $this->redirectToRoute('admin_model_cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/model_cv/new.html.twig', [
            'model_cv' => $modelCv,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="model_show", methods={"GET"})
     */
    public function show(ModelCv $modelCv): Response
    {
        return $this->render('admin/model_cv/show.html.twig', [
            'model_cv' => $modelCv,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="model_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ModelCv $modelCv): Response
    {
        $form = $this->createForm(ModelCvType::class, $modelCv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_model_cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/model_cv/edit.html.twig', [
            'model_cv' => $modelCv,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="model_del", methods={"POST"})
     */
    public function delete(Request $request, ModelCv $modelCv): Response
    {
        if ($this->isCsrfTokenValid('delete'.$modelCv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($modelCv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_model_cv_index', [], Response::HTTP_SEE_OTHER);
    }
}
