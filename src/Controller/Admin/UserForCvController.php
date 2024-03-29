<?php

namespace App\Controller\Admin;

use App\Entity\Cv;
use App\Entity\Langue;
use App\Entity\Profil;
use App\Entity\Contact;
use App\Entity\Reponse;
use App\Entity\Logiciel;
use App\Entity\Formation;
use App\Entity\UserForCv;
use App\Form\ProtoCvType;
use App\Entity\Competence;
use App\Entity\MonProtoCv;
use App\Form\UserForCvType;
use App\Form\UserForCv1Type;
use App\Entity\CentreInteret;
use App\Form\RepLogicielType;
use App\Entity\TacheEffectuer;
use App\Form\RepFormationType;
use App\Repository\UserForCvRepository;
use App\Entity\ExperienceProfessionnelle;
use App\Entity\MonContact;
use App\Form\CentreInteretType;
use App\Form\CompetenceType;
use App\Form\ContactType;
use App\Form\ExperienceProfessionnelleType;
use App\Form\FormationType;
use App\Form\LangueType;
use App\Form\LogicielType;
use App\Form\ProfilType;
use App\Form\RepCentreInteretType;
use App\Form\RepCompetenceType;
use App\Form\RepExperienceProType;
use App\Form\RepLangueType;
use App\Form\RepTacheType;
use App\Form\TacheEffectuerType;
use App\Repository\CentreInteretRepository;
use App\Repository\CompetenceRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ExperienceProfessionnelleRepository;
use App\Repository\FormationRepository;
use App\Repository\LangueRepository;
use App\Repository\LogicielRepository;
use App\Repository\ProfilRepository;
use App\Repository\TacheEffectuerRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;


class UserForCvController extends AbstractController
{

    /**
     * @Route("/admin/cv/", name="cv_index", methods={"GET"})
     */
    public function index(UserForCvRepository $userForCvRepository): Response
    {
        return $this->render('admin/user_for_cv/index.html.twig', [
            'user_for_cvs' => $userForCvRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/cv/new", name="cv_new", methods={"GET","POST"})
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

            /*             
            if ($form_encad_profil->isSubmitted() && $form_encad_profil->isValid()) {
            //pointons sur le repertoire upload qui contient les image uploadees
            $upload_dir = $this->getParameter("uploads_directory");

            //supprimons l'ancienne image avec unlink
            $r = unlink($upload_dir . "/" . $avatar);

            if ($r) {
                $file = $encadreur->getAvatar();
                //un nouveau nom avec md5
                $filename = md5(uniqid()) . "." . $file->guessExtension();
                //deplacons dans le dossier
                $file->move($upload_dir, $filename);
                //modifier l'ancien image par le nouveau nom
                $encadreur->setAvatar($filename);
                $manager->persist($encadreur);
                $manager->flush();
                return $this->redirectToRoute('gest_encadreur');
            }
        }
             */

            if (
                !empty($request->request->get("proto_cv")["nom"])
                && !empty($request->request->get("proto_cv")["prenom"])
                && !empty($request->request->get("proto_cv")["poste"])
            ) {
                //dd($request);
                //inserons l'image du proprietaire du cv
                //recuperons l'image du cv à partir de mon protoCv
                $file = $cv->getAvatar();
                //dd($file);
                //si le user n'a pas choisi d'image
                if (isset($file)) {
                    //dd($file);
                    //creer le dossier de stockage d'image
                    $upload_dir = $this->getParameter("cv_image_directory");
                    //generons un nom unique et recuerons l'extension de l'image
                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    //deplacons le fichier dans le dossier uploads qui est dans public avec le nouveau nom
                    $file->move($upload_dir, $filename);
                } //si l'utilisateur n'inserer
                else {
                    $filename = null;
                }

                #definissons un new userForCv
                $userForCv = new UserForCv();
                $userForCv->setNom($request->request->get("proto_cv")["nom"])
                    ->setPrenom($request->request->get("proto_cv")["prenom"])
                    ->setSexe($request->request->get("proto_cv")["sexe"])
                    ->setAvatar($filename)
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
                            #pour la recuperation des taches dans l'experiences professionnelles
                            // $t_tache = preg_replace('/\s\s+/',' ',$request->request->get("experience_pro_tache")[$i]);
                            $t_tache = explode(';', $t_tache);
                            foreach ($t_tache as  $value) {
                                #eviter d'inserer le dernier espace du au point virgule
                                if (!empty($value)) {
                                    $tache = new TacheEffectuer();
                                    $tache->setDescription($value)
                                        ->setExperienceProfessionnelle($ex->find($experience_pro->getId()));
                                    $entityManager->persist($tache);
                                    $entityManager->flush();
                                }
                            }
                            //dump($request->request->get("experience_pro_entreprise"));

                        }
                    }
                }


                #generons maintenant le numero de cv qui sera propre à un user
                if ($userForCv->getId() != 0) {
                    $num_cv = new Cv();
                    $num_cv->setUserForCv($repo->find($userForCv->getId()))
                        ->setNumCv(rand(1, 10000));
                    $entityManager->persist($num_cv);
                    $entityManager->flush();

                    $this->addFlash('success', "Un nouveau cv a été créé");
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
     * @Route("/admin/cv/{id}", name="cv_show", methods={"GET"})
     */
    public function show(UserForCv $userForCv): Response
    {
        return $this->render('admin/user_for_cv/show.html.twig', [
            'user_for_cv' => $userForCv,
        ]);
    }

    /**
     * @Route("/admin/cv/{id}/edit", name="cv_edit", methods={"GET","POST"})
     * @Route("/client/cv/{id}/edit", name="cv_edit_client", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        UserForCv $userForCv,
        ContactRepository $c,
        ProfilRepository $p,
        ExperienceProfessionnelleRepository $ex
    ): Response {
        $form = $this->createForm(UserForCvType::class, $userForCv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            if ($request->get("_route") == "cv_edit") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_client") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        //$contacts = $c->findBy(['userForCv'=>$userForCv->getId()]);
        $con = $c->findContactUser($userForCv->getId());
        $contact = new Contact();
        $contact->setAdresse($con->getAdresse())
            ->setTel($con->getTel())
            ->setEmail($con->getEmail());
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            //dd($request);
            $con->setAdresse($request->request->get("contact")["adresse"])
                ->setTel($request->request->get("contact")["tel"])
                ->setEmail($request->request->get("contact")["email"])
                ->setUserForCv($userForCv);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($con);
            $entityManager->flush();
            if ($request->get("_route") == "cv_edit") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_client") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        #modification du profil cv de l'utilisateur courant
        $pro = $p->findByProfilUser($userForCv->getId());
        $profile  = new Profil();
        $profile->setDescription($pro->getDescription())
            ->setUserForCv($userForCv);

        $formProfil = $this->createForm(ProfilType::class, $profile);
        $formProfil->handleRequest($request);
        if ($formProfil->isSubmitted() && $formProfil->isValid()) {
            //dd($request);
            $pro->setDescription($request->request->get("profil")["description"])
                ->setUserForCv($userForCv);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pro);
            $entityManager->flush();

            if ($request->get("_route") == "cv_edit") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_client") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        #ajouter une nouvelle langue sur la page de modification
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
                        <td><button class="btn btn-danger remove_langue">-</button></td>                      
                        </tr>';
            return new JsonResponse($ligne, 200);
        }
        #pour afficher la possibilite de cocher oui ou non pour un ajout quelconque
        $reponse = new Reponse();

        $formLangue = $this->createForm(RepLangueType::class, $reponse);

        $formLangue->handleRequest($request);
        if ($formLangue->isSubmitted() && $formLangue->isValid()) {
            #insertion des langues qui est un tableau de langue
            //dd($request);
            $t_langue_design = $request->request->get("langue_design");
            for ($i = 0; $i < count($t_langue_design); $i++) {
                if (
                    !empty($request->request->get("langue_design")[$i])
                    && !empty($request->request->get("langue_pourcent")[$i])
                ) {
                    $langue = new Langue();
                    $langue->setDesignation($request->request->get("langue_design")[$i])
                        ->setNiveauPourcent($request->request->get("langue_pourcent")[$i])
                        ->setUserForCv($userForCv);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($langue);
                    $entityManager->flush();

                    if ($request->get("_route") == "cv_edit") {
                        return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                    } else if ($request->get("_route") == "cv_edit_client") {
                        return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                    }
                }
            }
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
            <td><button class="btn btn-danger remove_logiciel">-</button></td>                      
        </tr>';
            return new JsonResponse($ligne, 200);
        }
        #pour l'ajout d'un logiciel dans la page d'editon
        $formLogiciel = $this->createForm(RepLogicielType::class, $reponse);
        $formLogiciel->handleRequest($request);
        if ($formLogiciel->isSubmitted() && $formLogiciel->isValid()) {
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
                        ->setUserForCv($userForCv);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($logiciel);
                    $entityManager->flush();
                }
            }
            #je dois ajouter les message flash
            if ($request->get("_route") == "cv_edit") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_client") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        #ajouter une competence
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
            <td><button class="btn btn-danger remove_competence">-</button></td>
            </tr>';
            return new JsonResponse($ligne, 200);
        }
        $formCompetence = $this->createForm(RepCompetenceType::class, $reponse);
        $formCompetence->handleRequest($request);
        if ($formCompetence->isSubmitted() && $formCompetence->isValid()) {
            $t_competence_design = $request->request->get("competence_design");

            for ($i = 0; $i < count($t_competence_design); $i++) {
                if (
                    !empty($request->request->get("competence_design")[$i])
                    && !empty($request->request->get("competence_pourcent")[$i])
                ) {
                    $competence = new Competence();
                    $competence->setDesignation($request->request->get("competence_design")[$i])
                        ->setNiveauPourcent($request->request->get("competence_pourcent")[$i])
                        ->setUserForCv($userForCv);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($competence);
                    $entityManager->flush();
                    if ($request->get("_route") == "cv_edit") {
                        return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                    } else if ($request->get("_route") == "cv_edit_client") {
                        return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                    }
                }
            }
            #add message flash
        }
        #pour le centre d'interet
        #si le bouton add centre intert est clique
        if ($request->request->get('centreInteret')) {
            $ligne = '
            <tr>
                    <td><input type="text" class="form-control" id="centre_interet_design[]" name="centre_interet_design[]"></td>
                    <td><button class="btn btn-danger remove_centre_interet">-</button></td>                      
            </tr>';
            return new JsonResponse($ligne, 200);
        }
        $formCentreInteret = $this->createForm(RepCentreInteretType::class, $reponse);
        $formCentreInteret->handleRequest($request);
        if (
            $formCentreInteret->isSubmitted()
            && $formCentreInteret->isValid()
        ) {
            //    dd($request);
            $t_centre_interet_design = $request->request->get("centre_interet_design");
            for ($i = 0; $i < count($t_centre_interet_design); $i++) {
                if (
                    !empty($request->request->get("centre_interet_design")[$i])
                ) {
                    $centre_interet = new CentreInteret();
                    $centre_interet->setDesignation($request->request->get("centre_interet_design")[$i])
                        ->setUserForCv($userForCv);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($centre_interet);
                    $entityManager->flush();
                    //dd($request->get("_route"));
                    if ($request->get("_route") == "cv_edit") {
                        return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                    } else if ($request->get("_route") == "cv_edit_client") {
                        return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                    }
                }
            }
            #add message flash

        }
        #pour la formation
        #si le bouton add formation est cliqué
        if ($request->request->get('formation')) {
            $ligne = '
                <tr>
                    <td><input type="text" class="form-control" id="formation_diplome[]" name="formation_diplome[]"></td>
                    <td><input type="text" class="form-control" id="formation_annee[]" name="formation_annee[]"></td>
                    <td><input type="text" class="form-control" id="formation_ville[]" name="formation_ville[]"></td>
                    <td><input type="text" class="form-control" id="formation_pays[]" name="formation_pays[]"></td>
                    <td><input type="text" class="form-control" id="formation_ecole[]" name="formation_ecole[]"></td>
                    <td><button class="btn btn-danger remove_formation">-</button></td>                      
                </tr>
                    ';
            return new JsonResponse($ligne, 200);
        }
        $formFormation = $this->createForm(RepFormationType::class, $reponse);
        $formFormation->handleRequest($request);
        if (
            $formFormation->isSubmitted()
            && $formFormation->isValid()
        ) {
            //dd($request);
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
                        ->setUserForCv($userForCv);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($formation);
                    $entityManager->flush();
                    //dd($request->get("_route"));
                    if ($request->get("_route") == "cv_edit") {
                        return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                    } else if ($request->get("_route") == "cv_edit_client") {
                        return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                    }
                }
            }
        }
        #pour ajouter une experience pro dans la partie edit
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
                <td><button class="btn btn-danger remove_experience_pro">-</button></td>                      

            </tr>  
            ';
            return new JsonResponse($ligne, 200);
        }

        $formExperience = $this->createForm(RepExperienceProType::class, $reponse);
        $formExperience->handleRequest($request);
        if (
            $formExperience->isSubmitted()
            && $formExperience->isValid()
        ) {
            //dd($request);
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
                    $experience_pro->setUserForCv($userForCv)
                        ->setNomEntreprise($request->request->get("experience_pro_entreprise")[$i])
                        ->setPosteOccupe($request->request->get("experience_pro_poste")[$i])
                        ->setAnneeOccupation($request->request->get("experience_pro_annee")[$i]);
                    #enlevons les retours au chariot
                    $t_tache = preg_replace('/\s\s+/', ' ', $request->request->get("experience_pro_tache")[$i]);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($experience_pro);
                    $entityManager->flush();

                    if ($experience_pro->getId() != 0) {
                        #pour la recuperation des taches dans l'experiences professionnelles
                        // $t_tache = preg_replace('/\s\s+/',' ',$request->request->get("experience_pro_tache")[$i]);
                        $t_tache = explode(';', $t_tache);
                        foreach ($t_tache as  $value) {
                            // dd($t_tache);
                            #eviter d'inserer le dernier espace du au point virgule
                            if (!empty($value)) {
                                $tache = new TacheEffectuer();
                                $tache->setDescription($value)
                                    ->setExperienceProfessionnelle($ex->find($experience_pro->getId()));
                                $entityManager = $this->getDoctrine()->getManager();
                                $entityManager->persist($tache);
                                $entityManager->flush();
                            }
                        }
                        //dd($request->get("_route"));
                        if ($request->get("_route") == "cv_edit") {
                            return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                        } else if ($request->get("_route") == "cv_edit_client") {
                            return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
                        }
                        //dump($request->request->get("experience_pro_entreprise"));

                    }
                }
            }
            #message flash et redirection sur la meme page
        }
        return $this->renderForm('admin/user_for_cv/edit.html.twig', [
            'userforcv' => $userForCv,
            'form' => $form,
            'contact' => $formContact,
            'profil' => $formProfil,
            'RepFormLangue' => $formLangue,
            'RepFormLogiciel' => $formLogiciel,
            'RepFormCompetence' => $formCompetence,
            'RepCentreInteret' => $formCentreInteret,
            'RepFormation' => $formFormation,
            'RepExperience' => $formExperience
        ]);
    }

    /**
     * @Route("/admin/cv/{id}", name="cv_delete", methods={"POST"})
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
    /**
     * @Route("/admin/cv/{id}/lg/{id_lg}/edit", name="cv_edit_lg",methods={"POST","GET"})
     * @Route("/client/cv/{id}/lg/{id_lg}/edit", name="cv_edit_client_lg",methods={"POST","GET"})
     */
    public function edit_langue(Request $request, UserForCv $userForCv, $id_lg, LangueRepository $l)
    {
        $langue = $l->find($id_lg);
        $langue->setDesignation($langue->getDesignation())
            ->setNiveauPourcent($langue->getNiveauPourcent());

        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $langue->setDesignation($request->request->get("langue")["designation"])
                ->setNiveauPourcent($request->request->get("langue")["niveau_pourcent"]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($langue);
            $entityManager->flush();

            //verification des urls si c'est admin ou client afin de savoir comment rediriger
            //dd($request->get("_route"));
            if ($request->get("_route") == "cv_edit_lg") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_client_lg") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm(
            "admin/user_for_cv/langue_edit.html.twig",
            [
                'form' => $form,
                'langue' => $l->find($id_lg),
                'userForcv' => $userForCv
            ]
        );
    }
    /**
     * @Route("/admin/cv/{id}/del_lg",name="del_lg",methods={"POST","GET"})
     * @Route("/client/cv/{id}/del_lg",name="del_lg_client",methods={"POST","GET"})
     */
    public function delete_langue(Request $request, UserForCv $userForCv, LangueRepository $l)
    {
        $id_lg = $request->request->get("idL");
        if ($l->find($id_lg)) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($l->find($id_lg));
            $entityManager->flush();
            $response = "ok";
        } else {
            $response = "bad";
        }
        return new JsonResponse($response, 200);
        // return new JsonResponse(
        //     ["designation"=>$l->find($id_lg)->getDesignation(),
        // "pourcentage"=>$l->find($id_lg)->getNiveauPourcent()],200);
    }
    /**
     * @Route("/admin/cv/{id}/log/{id_log}/edit", name="cv_edit_log",methods={"POST","GET"})
     * @Route("/client/cv/{id}/log/{id_log}/edit", name="cv_edit_log_client",methods={"POST","GET"})
     */
    public function edit_logiciel(Request $request, UserForCv $userForCv, $id_log, LogicielRepository $l)
    {
        $logiciel = $l->find($id_log);
        $logiciel->setDesignation($logiciel->getDesignation())
            ->setNiveauPourcent($logiciel->getNiveauPourcent());

        $form = $this->createForm(LogicielType::class, $logiciel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $logiciel->setDesignation($request->request->get("logiciel")["designation"])
                ->setNiveauPourcent($request->request->get("logiciel")["niveau_pourcent"]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($logiciel);
            $entityManager->flush();
            //dd($request->get("_route"));
            if ($request->get("_route") == "cv_edit_log") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_log_client") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm(
            "admin/user_for_cv/logiciel_edit.html.twig",
            [
                'form' => $form,
                'logiciel' => $l->find($id_log),
                'userForcv' => $userForCv
            ]
        );
    }
    /**
     * @Route("/admin/cv/{id}/del_log",name="del_log",methods={"POST","GET"})
     * @Route("/client/cv/{id}/del_log",name="del_log_client",methods={"POST","GET"})
     */
    public function delete_logiciel(Request $request, UserForCv $userForCv, LogicielRepository $l, EntityManagerInterface $em)
    {
        $id_log = $request->request->get("idLog");
        if ($l->find($id_log)) {
            $em->remove($l->find($id_log));
            $em->flush();
            $response = "ok";
        } else {
            $response = "non";
        }
        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/admin/cv/{id}/comp/{id_comp}/edit",name="cv_edit_comp",methods={"POST","GET"})
     * @Route("/client/cv/{id}/comp/{id_comp}/edit",name="cv_edit_comp_client",methods={"POST","GET"})
     */
    public function edit_competence(
        Request $request,
        UserForCv $userForCv,
        $id_comp,
        CompetenceRepository $c,
        EntityManagerInterface $em
    ) {
        $competence = $c->find($id_comp);
        $competence->setDesignation($competence->getDesignation())
            ->setNiveauPourcent($competence->getNiveauPourcent());
        $formCompetence = $this->createForm(CompetenceType::class, $competence);
        $formCompetence->handleRequest($request);
        if ($formCompetence->isSubmitted() && $formCompetence->isValid()) {
            $competence->setDesignation($request->request->get("competence")["designation"])
                ->setNiveauPourcent($request->request->get("competence")["niveau_pourcent"])
                ->setUserForCv($userForCv);
            $em->persist($competence);
            $em->flush();
            // dd($request->get("_route"));
            if ($request->get("_route") == "cv_edit_comp") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_comp_client") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm(
            'admin/user_for_cv/competence_edit.html.twig',
            [
                'competence' => $c->find($id_comp),
                'form' => $formCompetence,
                'userForcv' => $userForCv
            ]
        );
    }

    /**
     * @Route("/admin/cv/{id}/del_comp",name="del_comp",methods={"POST","GET"})
     * @Route("/client/cv/{id}/del_comp",name="del_comp_client",methods={"POST","GET"})
     */
    public function delete_competence(
        Request $request,
        UserForCv $userForCv,
        CompetenceRepository $c,
        EntityManagerInterface $em
    ) {
        $id_comp = $request->request->get("idComp");
        if ($c->find($id_comp)) {
            $em->remove($c->find($id_comp));
            $em->flush();
            $response = 'ok';
        } else {
            $response = 'non';
        }
        return new JsonResponse($response, 200);
    }
    /**
     * @Route("/admin/cv/{id}/ci/{id_ci}/edit",name="cv_edit_ci",methods={"POST","GET"})
     * @Route("/client/cv/{id}/ci/{id_ci}/edit",name="cv_edit_ci_client",methods={"POST","GET"})
     */
    public function edit_centre_interet(
        Request $request,
        UserForCv $userForCv,
        CentreInteretRepository $ci,
        EntityManagerInterface $em,
        $id_ci
    ) {
        $centre_interet = $ci->find($id_ci);
        $centre_interet->setDesignation($centre_interet->getDesignation());
        $form = $this->createForm(CentreInteretType::class, $centre_interet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($request);
            $centre_interet->setDesignation($request->request->get("centre_interet")["designation"])
                ->setUserForCv($userForCv);
            $em->persist($centre_interet);
            $em->flush();

            //dd($request->get("_route"));
            if ($request->get("_route") == "cv_edit_comp") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_ci_client") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm(
            "admin/user_for_cv/centre_interet_edit.html.twig",
            [
                "centreInteret" => $ci->find($id_ci),
                "form" => $form,
                "userForcv" => $userForCv
            ]
        );
    }
    /**
     * @Route("/admin/cv/{id}/del_ci",name="del_ci",methods={"POST","GET"})
     * @Route("/client/cv/{id}/del_ci",name="del_ci_client",methods={"POST","GET"})
     */
    public function delete_centre_interet(
        Request $request,
        EntityManagerInterface $em,
        CentreInteretRepository $ci
    ) {
        $id_ci = $request->request->get("idCi");
        if ($ci->find($id_ci)) {
            $em->remove($ci->find($id_ci));
            $em->flush();
            $response = "ok";
        } else {
            $response = "non";
        }
        return new JsonResponse($response, 200);
    }
    /**
     * @Route("/admin/cv/{id}/for/{id_forma}/edit",name="cv_edit_forma",methods={"POST","GET"})
     * @Route("/client/cv/{id}/for/{id_forma}/edit",name="cv_edit_forma_client",methods={"POST","GET"})
     */
    public function edit_formation(
        Request $request,
        UserForCv $userForCv,
        FormationRepository $fo,
        EntityManagerInterface $em,
        $id_forma
    ) {
        $formation = $fo->find($id_forma);
        $formation->setDiplome($formation->getDiplome())
            ->setAnnee($formation->getAnnee())
            ->setEcoleObtention($formation->getEcoleObtention())
            ->setVille($formation->getVille())
            ->setPays($formation->getPays());
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($request);
            $formation->setDiplome($request->request->get("formation")["diplome"])
                ->setAnnee($request->request->get("formation")["annee"])
                ->setEcoleObtention($request->request->get("formation")["ecoleObtention"])
                ->setVille($request->request->get("formation")["Ville"])
                ->setPays($request->request->get("formation")["pays"])
                ->setUserForCv($userForCv);
            $em->persist($formation);
            $em->flush();
            //dd($request->get("_route"));
            if ($request->get("_route") == "cv_edit_forma") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_forma_client") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm(
            "admin/user_for_cv/formation_edit.html.twig",
            [
                "formation" => $fo->find($id_forma),
                "form" => $form,
                "userForcv" => $userForCv
            ]
        );
    }

    /**
     * @Route("/admin/cv/{id}/del_for",name="del_forma",methods={"POST","GET"})
     * @Route("/client/cv/{id}/del_for",name="del_forma_client",methods={"POST","GET"})
     */
    public function delete_formation(
        Request $request,
        EntityManagerInterface $em,
        FormationRepository $fo
    ) {
        $id_fo = $request->request->get("idFo");
        if ($fo->find($id_fo)) {
            $em->remove($fo->find($id_fo));
            $em->flush();
            $response = "ok";
        } else {
            $response = "non";
        }
        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/admin/cv/{id}/exp/{id_exp}/edit",name="cv_edit_exp",methods={"POST","GET"})
     * @Route("/client/cv/{id}/exp/{id_exp}/edit",name="cv_edit_exp_client",methods={"POST","GET"})
     */
    public function edit_experience_pro(
        Request $request,
        UserForCv $userForCv,
        ExperienceProfessionnelleRepository $exp,
        EntityManagerInterface $em,
        $id_exp
    ) {
        $experience_pro = $exp->find($id_exp);
        $experience_pro->setNomEntreprise($experience_pro->getNomEntreprise())
            ->setPosteOccupe($experience_pro->getPosteOccupe())
            ->setAnneeOccupation($experience_pro->getAnneeOccupation());

        $form = $this->createForm(ExperienceProfessionnelleType::class, $experience_pro);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($request);
            $experience_pro->setNomEntreprise($request->request->get("experience_professionnelle")["nomEntreprise"])
                ->setPosteOccupe($request->request->get("experience_professionnelle")["posteOccupe"])
                ->setAnneeOccupation($request->request->get("experience_professionnelle")["anneeOccupation"])
                ->setUserForCv($userForCv);
            $em->persist($experience_pro);
            $em->flush();
            //dd($request->get("_route"));
            if ($request->get("_route") == "cv_edit_exp") {
                return $this->redirectToRoute('cv_edit', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_exp_client") {
                return $this->redirectToRoute('cv_edit_client', ['id' => $userForCv->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        #pour la tache de façon independante
        #si le bouton add tache est clique
        if ($request->request->get('tache')) {
            $ligne = '
            <tr>
                    <td><input type="text" class="form-control" id="tache_description[]" name="tache_description[]"></td>
                    <td><button class="btn btn-danger remove_tache">-</button></td>                      
            </tr>';
            return new JsonResponse($ligne, 200);
        }
        $reponse = new Reponse();
        $formTache = $this->createForm(RepTacheType::class, $reponse);
        $formTache->handleRequest($request);
        if (
            $formTache->isSubmitted()
            && $formTache->isValid()
        ) {
            //dd($request);
            $t_tache_exp = $request->request->get("tache_description");

            for ($i = 0; $i < count($t_tache_exp); $i++) {
                if (
                    !empty($request->request->get("tache_description")[$i])
                ) {
                    $tache = new TacheEffectuer();
                    $tache->setDescription($request->request->get("tache_description")[$i])
                        ->setExperienceProfessionnelle($exp->find($id_exp));
                    $em->persist($tache);
                    $em->flush();
                }
            }
            #add message flash
           // dd($request->get("_route"));
            if ($request->get("_route") == "cv_edit_exp") {
                return $this->redirectToRoute('cv_edit_exp', [
                    'id' => $userForCv->getId(),
                    'id_exp' => $exp->find($id_exp)->getId()
                ], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_exp_client") {
                return $this->redirectToRoute('cv_edit_exp_client', [
                    'id' => $userForCv->getId(),
                    'id_exp' => $exp->find($id_exp)->getId()
                ], Response::HTTP_SEE_OTHER);
            }

        }
        return $this->renderForm(
            "admin/user_for_cv/experience_pro_edit.html.twig",
            [
                "experience" => $exp->find($id_exp),
                "form" => $form,
                "userForcv" => $userForCv,
                "RepTache" => $formTache
            ]
        );
    }
    /**  
     * @Route("/admin/cv/{id}/del_exp",name="del_exp",methods={"POST","GET"})
     * @Route("/client/cv/{id}/del_exp",name="del_exp_client",methods={"POST","GET"})
     */
    public function delete_experience_pro(
        Request $request,
        EntityManagerInterface $em,
        ExperienceProfessionnelleRepository $exp

    ) {
        $id_exp = $request->request->get("idExp");
        if ($exp->find($id_exp)) {
            //allons d'abord supprimer l'enseùble des taches qui depndent d'elle
            $experience = $exp->find($id_exp);
            $taches = $experience->getTaches();
            foreach ($taches as $tache) {
                $em->remove($tache);
                $em->flush();
            }
            $em->remove($exp->find($id_exp));
            $em->flush();
            $response = "ok";
            #message flash
        } else {
            $response = "non";
        }
        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/admin/cv/{id}/exp/{id_exp}/tac/{id_tache}/edit",name="cv_edit_tache_experience",methods={"POST","GET"})
     * @Route("/client/cv/{id}/exp/{id_exp}/tac/{id_tache}/edit",name="cv_edit_tache_experience_client",methods={"POST","GET"})
     */
    public function edit_tache_experience(
        Request $request,
        UserForCv $userForCv,
        $id_exp,
        $id_tache,
        TacheEffectuerRepository $ta,
        ExperienceProfessionnelleRepository $exp,
        EntityManagerInterface $em
    ) {
        $tache = $ta->find($id_tache);
        $tache->setDescription($tache->getDescription());
        $form = $this->createForm(TacheEffectuerType::class, $tache);
        $form->handleRequest($request);
        if (
            $form->isSubmitted()
            && $form->isValid()
        ) {
            //dd($request);
            $tache->setDescription($request->request->get("tache_effectuer")["description"])
                ->setExperienceProfessionnelle($exp->find($id_exp));
            $em->persist($tache);
            $em->flush();

            #message flash
            //dd($request->get("_route"));
            if ($request->get("_route") == "cv_edit_tache_experience") {
                return $this->redirectToRoute('cv_edit_exp', ['id' => $userForCv->getId(), 'id_exp' => $exp->find($id_exp)->getId()], Response::HTTP_SEE_OTHER);
            } else if ($request->get("_route") == "cv_edit_tache_experience_client") {
                return $this->redirectToRoute('cv_edit_exp_client', ['id' => $userForCv->getId(), 'id_exp' => $exp->find($id_exp)->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm(
            'admin/user_for_cv/tache_experience_edit.html.twig',
            [
                'form' => $form,
                'userForcv' => $userForCv,
                'tache' => $ta->find($id_tache),
                'experience' => $exp->find($id_exp)
            ]
        );
    }

    /**
     * @Route("/admin/cv/{id}/del_tac",name="del_tache_experience",methods={"POST","GET"})
     * @Route("/client/cv/{id}/del_tac",name="del_tache_experience_client",methods={"POST","GET"})
     */
    public function delete_tache_experience_pro(
        Request $request,
        EntityManagerInterface $em,
        TacheEffectuerRepository $ta
    ) {
        $id_tac = $request->request->get("idTac");
        if ($ta->find($id_tac)) {
            $em->remove($ta->find($id_tac));
            $em->flush();
            $response = "ok";
        } else {
            $response = "non";
        }
        return new JsonResponse($response, 200);
    }
}
