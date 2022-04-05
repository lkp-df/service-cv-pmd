<?php

namespace App\Controller\Admin;

use App\Entity\ModelCv;
use App\Entity\Image;
use App\Entity\Reponse;
use App\Form\ModelCvType;
use App\Form\ModelCvType2;
use App\Form\ModelCvType3;
use App\Repository\ModelCvRepository;
use Doctrine\ORM\EntityManager;
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
            //dd($request);
            //nous allons utiliser le getData au lieu de request
            //dd($request->request->get('model_cv')['designation']);
            if (
                $form->get('designation')->getData() != ""
                && $form->get('prix')->getData() != ""
                && $form->get('createur')->getData() != ""
            ) {
                //recuperons l'image du modele
                $file = $form->get('image')->getData();
                //on pointe sur le dossier de stockage des images où l'on mettra les models
                $upload_dir = $this->getParameter('modele_image_directory');
                //generons un nom unique et recuperons l'extension de l'image
                $fileName = md5(uniqid()) . '.' . $file->guessExTension();
                //deplacons le fichier dans le dossier uploads qui est dans public avec le nouveau nom
                $file->move($upload_dir, $fileName);
                //on modifie le nom de l'image avec le nouveau nom
                $modelCv->setImage($fileName);
                $em = $this->getDoctrine()->getManager();
                $em->persist($modelCv);
                $em->flush();
                //redirection apres insertion
                return $this->redirectToRoute('model_index', [], Response::HTTP_SEE_OTHER);

            }

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
        $form = $this->createForm(ModelCvType2::class, $modelCv);
        $form->handleRequest($request);

        $image = new Image();
        $formImage = $this->createForm(ModelCvType3::class,$image);
        $formImage->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('model_show', ['id'=>$modelCv->getId()], Response::HTTP_SEE_OTHER);
        }
        //pour la modification de l'image
        if($formImage->isSubmitted()&&$formImage->isValid()){
          //dd($formImage->get('image')->getData());
            //l'ancien nom de l'image
            $avatar = $modelCv->getImage();

            $file = $formImage->get('image')->getData();
             //on pointe sur le dossier de stockage des images des modeles cv
             $upload_dir = $this->getParameter('modele_image_directory');
            //un nouveau nom avec md5
            $filename = md5(uniqid()) . "." . $file->guessExtension();
            //deplacons dans le dossier
            $file->move($upload_dir, $filename);

             //on va supprimer cette ancienne image dans le dossier des images de CV
             $r = unlink($upload_dir . "/" . $avatar);

             //on verifie si la suprresion est bien effectuée, on insert la nouvelle image
             if ($r) {
                //modifier l'ancien image par le nouveau nom
                $modelCv->setImage($filename);
                $em = $this->getDoctrine()->getManager();
                $em->persist($modelCv);
                $em->flush();
                return $this->redirectToRoute('model_show', ['id'=>$modelCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('admin/model_cv/edit.html.twig', [
            'model_cv' => $modelCv,
            'form' => $form,
            'formImage' => $formImage,
        ]);
    }

    /**
     * @Route("/{id}", name="model_del", methods={"POST"})
     */
    public function delete(Request $request, ModelCv $modelCv): Response
    {
        if ($this->isCsrfTokenValid('delete' . $modelCv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($modelCv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_model_cv_index', [], Response::HTTP_SEE_OTHER);
    }
}
