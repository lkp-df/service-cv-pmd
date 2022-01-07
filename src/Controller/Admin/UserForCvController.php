<?php

namespace App\Controller\Admin;

use App\Entity\MonProtoCv;
use App\Entity\Reponse;
use App\Entity\UserForCv;
use App\Form\ProtoCvType;
use App\Form\RepFormationType;
use App\Form\RepLogicielType;
use App\Form\UserForCv1Type;
use App\Repository\UserForCvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cv")
 */
class UserForCvController extends AbstractController
{
    /**
     * @Route("/", name="cv_index", methods={"GET"})
     */
    public function index(UserForCvRepository $userForCvRepository): Response
    {
        return $this->render('admin/user_for_cv/index.html.twig', [
            'user_for_cvs' => $userForCvRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cv_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cv = new MonProtoCv();
        $form = $this->createForm(ProtoCvType::class, $cv);
        $form->handleRequest($request);

        #pour les reponses qui ne sont pas obilagatoire
        $rep = new Reponse();

        #si le boutton addcompetence est clique
        if ($request->request->get('competence')) {
            $ligne = '<tr>';
            $ligne .= '
            <td><input type="text" class="form-control" id="competence_design[]" name="competence_design[]"></td>
            <td><select name="competence_pourcent[]" class="form-control" id="competence_pourcent[]">
                <option >niveau de pourcent</option>
                <option value="10">10%</option>
                <option value="20">20%</option>
                <option value="30">30%</option>
                <option value="40">40%</option>
                <option value="50">50%</option>
                <option value="60">60%</option>
                <option value="70">70%</option>
                <option value="80">80%</option>
                <option value="90">90%</option>
                <option value="100">100%</option>
            </select></td>
            <td><button class="btn btn-danger comptence_remove">-</button></td>
            </tr>';
            return new JsonResponse($ligne, 200);
        }
        #si le bouton addLangue est cliqué
        if ($request->request->get('langue')) {
            $ligne = '
            <tr>
                 <td><input type="text" class="form-control" id="langue_design[]" name="langue_design[]"></td>
                 <td><select name="langue_pourcent[]" class="form-control" id="langue_pourcent[]">
                                <option >niveau de pourcent</option>
                                <option value="10">10%</option>
                                <option value="20">20%</option>
                                <option value="30">30%</option>
                                <option value="40">40%</option>
                                <option value="50">50%</option>
                                <option value="60">60%</option>
                                <option value="70">70%</option>
                                <option value="80">80%</option>
                                <option value="90">90%</option>
                                <option value="100">100%</option>
                            </select>
                        </td>
                        <td><button class="btn btn-danger langue_remove">-</button></td>                      
                        </tr>';
            return new JsonResponse($ligne, 200);
        }

        #si le bouton add centre intert est clique
        if ($request->request->get('centreInteret')) {
            $ligne = '
            <tr>
                    <td><input type="text" class="form-control" id="centre_interet_design[]" name="centre_interet_design[]"></td>
                    <td><button class="btn btn-danger centre_interet_remove">-</button></td>                      
            </tr>';
            return new JsonResponse($ligne,200);
        }
        #si le bouton add logiciel est clique
        if($request->request->get('logiciel')){
            $ligne = '
            <tr>
            <td><input type="text" class="form-control" id="logiciel_design[]" name="logiciel_design[]"></td>
            <td>
                <select name="logiciel_pourcent[]" class="form-control" id="logiciel_pourcent[]">
                    <option >niveau de pourcent</option>
                    <option value="10">10%</option>
                    <option value="20">20%</option>
                    <option value="30">30%</option>
                    <option value="40">40%</option>
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90">90%</option>
                    <option value="100">100%</option>
                </select>
            </td>
            <td><button class="btn btn-danger logiciel_remove">-</button></td>                      
        </tr>';
            return new JsonResponse($ligne,200);
        }

        #si le bouton add formation est cliqué
        if($request->request->get('formation')){
            $ligne = '
                <tr>
                    <td><input type="text" class="form-control" id="formation_diplome[]" name="formation_diplome[]"></td>
                    <td><input type="text" class="form-control" id="formation_annee[]" name="formation_annee[]"></td>
                    <td><input type="text" class="form-control" id="formation_ville[]" name="formation_ville[]"></td>
                    <td><input type="text" class="form-control" id="formation_pays[]" name="formation_pays[]"></td>
                    <td><input type="text" class="form-control" id="formation_ecole[]" name="formation_ecole[]"></td>
                    <td><button class="btn btn-danger formation_remove">-</button></td>                      
                </tr>
                    ';
            return new JsonResponse($ligne,200);
        }

        #si le bouton add experience est cliqué
        if($request->request->get('experience')){
            $ligne = '
            <tr>
                <td><input type="text" class="form-control" id="experience_pro_entreprise[]" name="experience_pro_entreprise[]"></td>
                <td><input type="text" class="form-control" id="experience_pro_poste[]" name="experience_pro_poste[]"></td>
                <td><input type="text" class="form-control" id="experience_pro_annee[]" name="experience_pro_annee[]"></td>
                <td><input type="text" class="form-control" id="experience_pro_tache[]" name="experience_pro_tache[]"></td>
                <td><button class="btn btn-danger experience_pro_remove">-</button></td>                      

            </tr>  
            ';
            return new JsonResponse($ligne,200);
        }

        $formLogiciel = $this->createForm(RepLogicielType::class, $rep);

        $formFormation = $this->createForm(RepFormationType::class, $rep);

        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($cv);
            // $entityManager->flush();

            // return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user_for_cv/new.html.twig', [
            'form' => $form,
            'formLogiciel' => $formLogiciel,
            'formFormation' => $formFormation
        ]);
    }

    /**
     * @Route("/{id}", name="cv_show", methods={"GET"})
     */
    public function show(UserForCv $userForCv): Response
    {
        return $this->render('admin/user_for_cv/show.html.twig', [
            'user_for_cv' => $userForCv,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cv_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserForCv $userForCv): Response
    {
        $form = $this->createForm(UserForCv1Type::class, $userForCv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user_for_cv/edit.html.twig', [
            'user_for_cv' => $userForCv,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cv_delete", methods={"POST"})
     */
    public function delete(Request $request, UserForCv $userForCv): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userForCv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userForCv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
    }
}
