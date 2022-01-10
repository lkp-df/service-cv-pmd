<?php

namespace App\Controller\Admin;

use App\Entity\CentreInteret;
use App\Entity\Competence;
use App\Entity\Contact;
use App\Entity\Cv;
use App\Entity\ExperienceProfessionnelle;
use App\Entity\Formation;
use App\Entity\Langue;
use App\Entity\Logiciel;
use App\Entity\MonProtoCv;
use App\Entity\Profil;
use App\Entity\Reponse;
use App\Entity\TacheEffectuer;
use App\Entity\UserForCv;
use App\Form\ProtoCvType;
use App\Form\RepFormationType;
use App\Form\RepLogicielType;
use App\Form\UserForCv1Type;
use App\Repository\ExperienceProfessionnelleRepository;
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
    public function new(Request $request, UserForCvRepository $repo, ExperienceProfessionnelleRepository $ex): Response
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
            return new JsonResponse($ligne, 200);
        }
        #si le bouton add logiciel est clique
        if ($request->request->get('logiciel')) {
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
            return new JsonResponse($ligne, 200);
        }

        #si le bouton add formation est cliqué
        if ($request->request->get('formation')) {
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
            return new JsonResponse($ligne, 200);
        }

        #si le bouton add experience est cliqué
        if ($request->request->get('experience')) {
            $ligne = '
            <tr>
                <td><input type="text" class="form-control" id="experience_pro_entreprise[]" name="experience_pro_entreprise[]" placeholder="saisir le nom de l\'entreprise"></td>
                <td><input type="text" class="form-control" id="experience_pro_poste[]" name="experience_pro_poste[]" placeholder="saisir le poste Occupé"></td>
                <td><input type="text" class="form-control" id="experience_pro_annee[]" name="experience_pro_annee[]" placeholder="saisir l\'année à laquelle vous avez travaillé dans la société"></td>
                <td>
                <textarea placeholder="veuillez separer chaque tache effecuter par un point virgule (;)" name="experience_pro_tache[]" id="experience_pro_tache[]" class="form-control" cols="5" rows="5"></textarea>
                </td>
                <td><button class="btn btn-danger experience_pro_remove">-</button></td>                      

            </tr>  
            ';
            return new JsonResponse($ligne, 200);
        }

        $formLogiciel = $this->createForm(RepLogicielType::class, $rep);

        $formFormation = $this->createForm(RepFormationType::class, $rep);

        if ($form->isSubmitted() && $form->isValid()) {
            //dump($request);
            if(!empty($request->request->get("proto_cv")["nom"])
            && !empty($request->request->get("proto_cv")["prenom"])
            && !empty($request->request->get("proto_cv")["avatar"])
            && !empty($request->request->get("proto_cv")["poste"]))
            {
                
            
            #definissons un new userForCv
            $userForCv = new UserForCv();
            $userForCv->setNom($request->request->get("proto_cv")["nom"])
                ->setPrenom($request->request->get("proto_cv")["prenom"])
                ->setAvatar($request->request->get("proto_cv")["avatar"])
                ->setPosteRechercheOccupe($request->request->get("proto_cv")["poste"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userForCv);
            $entityManager->flush();

            #insertion du profil de l'utilisateur
            $profil = new Profil();
            $profil->setDescription($request->request->get("proto_cv")["profil"])
                ->setUserForCv($repo->find($userForCv->getId()));
            $entityManager->persist($profil);
            $entityManager->flush();

            #insertion du contact de l'utilisateur
            $contact = new Contact();
            $contact->setEmail($request->request->get("proto_cv")["email"])
                ->setTel($request->request->get("proto_cv")["tel"])
                ->setAdresse($request->request->get("proto_cv")["adresse"]);
            $contact->setUserForCv($repo->find($userForCv->getId()));
            $entityManager->persist($contact);
            $entityManager->flush();

            #insertion des competences qui est un tableau des compétences
            $t_competence_design = $request->request->get("competence_design");

            for ($i = 0; $i < count($t_competence_design); $i++) {
                if (
                    !empty($request->request->get("competence_design")[$i])
                    && !empty($request->request->get("competence_pourcent")[$i])
                ) {
                    $competence = new Competence();
                    $competence->setDesignation($request->request->get("competence_design")[$i])
                        ->setNiveauPourcent($request->request->get("competence_pourcent")[$i])
                        ->setUserForCv($repo->find($userForCv->getId()));
                    $entityManager->persist($competence);
                    $entityManager->flush();
                }
            }

            #insertion des langues qui est un tableau de langue
            $t_langue_design = $request->request->get("langue_design");
            for ($i = 0; $i < count($t_langue_design); $i++) {
                if (
                    !empty($request->request->get("langue_design")[$i])
                    && !empty($request->request->get("langue_pourcent")[$i])
                ) {
                    $langue = new Langue();
                    $langue->setDesignation($request->request->get("langue_design")[$i])
                        ->setNiveauPourcent($request->request->get("langue_pourcent")[$i])
                        ->setUserForCv($repo->find($userForCv->getId()));
                    $entityManager->persist($langue);
                    $entityManager->flush();
                }
            }

            #insertion centre d'interet qui est un tableau de centre d'interet
            $t_centre_interet_design = $request->request->get("centre_interet_design");
            for ($i = 0; $i < count($t_centre_interet_design); $i++) {
                if (
                    !empty($request->request->get("centre_interet_design")[$i])
                ) {
                    $centre_interet = new CentreInteret();
                    $centre_interet->setDesignation($request->request->get("centre_interet_design")[$i])
                        ->setUserForCv($repo->find($userForCv->getId()));
                    $entityManager->persist($centre_interet);
                    $entityManager->flush();
                }
            }
            #insertion logiciel qui est un tableau de logiciel
            $t_logiciel_design = $request->request->get("logiciel_design");
            for ($i = 0; $i < count($t_logiciel_design); $i++) {
                if (
                    !empty($request->request->get("logiciel_design")[$i]
                        && !empty($request->request->get("logiciel_pourcent")[$i]))
                ) {
                    $logiciel = new Logiciel();
                    $logiciel->setDesignation($request->request->get("logiciel_design")[$i])
                        ->setNiveauPourcent($request->request->get("logiciel_pourcent")[$i])
                        ->setUserForCv($repo->find($userForCv->getId()));
                    $entityManager->persist($logiciel);
                    $entityManager->flush();
                }
            }

            #insertion de la formation qui est un tableau de formation
            $t_formation  = $request->request->get("formation_diplome");
            for ($i = 0; $i < count($t_formation); $i++) {
                if (
                    !empty($request->request->get("formation_diplome")[$i]
                        && !empty($request->request->get("formation_annee")[$i])
                        && !empty($request->request->get("formation_ville")[$i])
                        && !empty($request->request->get("formation_pays")[$i])
                        && !empty($request->request->get("formation_ecole")[$i]))
                ) {
                    $formation = new Formation();
                    $formation->setDiplome($request->request->get("formation_diplome")[$i])
                        ->setAnnee($request->request->get("formation_annee")[$i])
                        ->setVille($request->request->get("formation_ville")[$i])
                        ->setPays($request->request->get("formation_pays")[$i])
                        ->setEcoleObtention($request->request->get("formation_ecole")[$i])
                        ->setUserForCv($repo->find($userForCv->getId()));
                    $entityManager->persist($formation);
                    $entityManager->flush();
                }
            }

            #insertion experience professionnelle qui est un tableau d'experience professionnelle
            $t_experience = $request->request->get("experience_pro_entreprise");

            for ($i = 0; $i < count($t_experience); $i++) {
                if (
                    !empty($request->request->get("experience_pro_entreprise")[$i])
                    && !empty($request->request->get("experience_pro_poste")[$i])
                    && !empty($request->request->get("experience_pro_annee")[$i])
                    && !empty($request->request->get("experience_pro_tache")[$i])
                ) {
                    $experience_pro = new ExperienceProfessionnelle();
                    $experience_pro->setUserForCv($repo->find($userForCv->getId()))
                        ->setNomEntreprise($request->request->get("experience_pro_entreprise")[$i])
                        ->setPosteOccupe($request->request->get("experience_pro_poste")[$i])
                        ->setAnneeOccupation($request->request->get("experience_pro_annee")[$i]);
                    #enlevons les retours au chariot
                    $t_tache = preg_replace('/\s\s+/', ' ', $request->request->get("experience_pro_tache")[$i]);

                    $entityManager->persist($experience_pro);
                    $entityManager->flush();

                    if ($experience_pro->getId() != 0) {
                        $tache = new TacheEffectuer();
                        $tache->setDescription($t_tache)
                            ->setExperienceProfessionnelle($ex->find($experience_pro->getId()));
                        $entityManager->persist($tache);
                        $entityManager->flush();
                    }
                }
                
            }
            #pour la recuperation des experiences professionnelles
            // $t_tache = preg_replace('/\s\s+/',' ',$request->request->get("experience_pro_tache")[$i]);
            // $t_tache= explode(';',$t_tache);
            //dump($request->request->get("experience_pro_entreprise"));
            
            #generons maintenant le numero de cv qui sera propre à un user
            if($userForCv->getId() != 0){
                $num_cv = new Cv();
                $num_cv->setUserForCv($repo->find($userForCv->getId()))
                ->setNumCv(rand(1,10000));
                $entityManager->persist($num_cv);
                $entityManager->flush();

                $this->addFlash('succes',"Un nouveau cv a été créé");
                return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
           }
        }

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
