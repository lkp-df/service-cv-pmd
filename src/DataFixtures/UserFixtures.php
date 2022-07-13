<?php

namespace App\DataFixtures;

use App\Entity\Cv;
use App\Entity\User;
use App\Entity\Langue;
use App\Entity\Profil;
use App\Entity\Contact;
use App\Entity\Logiciel;
use App\Entity\Personne;
use App\Entity\Formation;
use App\Entity\UserForCv;
use App\Entity\Competence;
use App\Entity\CentreInteret;
use App\Entity\TacheEffectuer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ExperienceProfessionnelle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\ModelCv;

class UserFixtures extends Fixture
{
    private $em;
    private $passwordEncoder;
    public function __construct(EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->em = $entityManagerInterface;
        $this->passwordEncoder = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {
        $users = array(
            array(
                'first_name' => 'Malick', 'last_name' => 'Tounkara', 'email' => 'user@mail.com',
                'roles' => ["ROLE_USER"]
            ),
            array(
                'first_name' => 'Mamadou', 'last_name' => 'Dieme', 'email' => 'editor@mail.com',
                'roles' => ["ROLE_EDITOR"]
            ),
            array(
                'first_name' => 'Pepin', 'last_name' => 'Ngoulou', 'email' => 'admin@mail.com',
                'roles' => ["ROLE_ADMIN"]
            ),
        );

        //cette partie comprend les infos propre au cv de chaque utilisateur créé
        $userForCVTable =
            [
                ["nom" => "Ngoulou", "prenom" => "Pepin", "avatar" => "lkp.png", "poste" => "developper Php", "sexe" => "homme"],
                ["nom" => "Dieme", "prenom" => "Mamadou", "avatar" => "nans.png", "poste" => "developper Java", "sexe" => "homme"],
                ["nom" => "Tounkara", "prenom" => "Malick", "avatar" => "tkr.png", "poste" => "developper Php", "sexe" => "homme"]
            ];
        $ci = [
            ["description" => "football"],
            ["description" => "Lecture"],
            ["description" => "Codage"],
            ["description" => "sport"]
        ];
        $competence = [
            ["designation" => "HTML", "pourcentage" => 60],
            ["designation" => "CSS", "pourcentage" => 70],
            ["designation" => "JAVAScript", "pourcentage" => 70],
            ["designation" => "Symfony", "pourcentage" => 60],
            ["designation" => "Angular", "pourcentage" => 60]
        ];
        $contact = [
            "tel" => "772375369", "email" => "lkp@mail.com", "adresse" => "derkle Immeuble Senvet",
        ];
        $experience = [
            ["entreprise" => "PMD Developper", "poste" => "Analyste Conceptionneur", "annee" => "2020"],
            ["entreprise" => "Elite Capital", "poste" => "Developpeur Web", "annee" => "2022"],
            ["entreprise" => "Fondate Palice", "poste" => "Directeur Evenementiel", "annee" => "2024"]
        ];
        $tache = [
            ["description" => "Responsable Modelisation"],
            ["description" => "Responsable Ressources Humaines"],
            ["description" => "Responsable Hebergment et Facturation"]
        ];
        $formation = [
            [
                "annee" => "2018-2019", "ville" => "dakar",
                "pays" => "sénégal", "diplome" => "DTS en Analyste Programmeur",
                "ecole" => "IPG-ISTI"
            ],
            [
                "annee" => "2019-2020", "ville" => "dakar",
                "pays" => "sénégal", "diplome" => "Licence en Génie  Logiciel",
                "ecole" => "IPG-ISTI"
            ],
            [
                "annee" => "2019-2020", "ville" => "dakar",
                "pays" => "sénégal", "diplome" => "Certificat Methodologie DevopS",
                "ecole" => "OPEN CLASSROOM"
            ]
        ];

        $langue = [
            ["designation" => "français", "pourcent" => "60"],
            ["designation" => "Anglais", "pourcent" => "60"],
            ["designation" => "Espagnol", "pourcent" => "60"],
        ];
        $logiciel = [
            ["designation" => "Pack OFFice", "pourcent" => "70"],
            ["designation" => "Google Meet", "pourcent" => "80"],
            ["designation" => "Power AMC", "pourcent" => "60"],
            ["designation" => "Mysql WorkBench", "pourcent" => "60"],
        ];
        $profil = [
            "description" => "je suis passionné du développement informatique et des solutions High Tech",
        ];
        //on mettra un compteur
        $cv = [
            ["numCv" => 1, "user_id" => 1],
            ["numCv" => 2, "user_id" => 2],
            ["numCv" => 3, "user_id" => 3],
        ];
        $i = 0;
        foreach ($users as $value) {
            $user = new User();
            $personne = new Personne();
            $personne->setFirstName($value['first_name'])
                ->setLastName($value['last_name']);
            $user->setEmail($value['email']);
            $user->setIsVerified(true);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'password'))
                ->setRoles($value['roles'])
                ->setPersonne($personne);
            $this->em->persist($user);
            $this->em->flush();

            if ($user->getId()) {

                //insertion des cv des trois user de base

                $userCv = new UserForCv();

                $userCv->setNom($userForCVTable[$i]["nom"])->setPrenom($userForCVTable[$i]["prenom"])->setSexe($userForCVTable[$i]["sexe"])
                    ->setAvatar($userForCVTable[$i]["avatar"])->setPosteRechercheOccupe($userForCVTable[$i]["poste"]);
                $this->em->persist($userCv);
                $this->em->flush();
                //inserons les elements du user: centre interet, formation,...
                if ($userCv->getId()) {

                    //j'insere un ensemble de centre d'interet qui est un tableau
                    foreach ($ci as $value) {
                        $CI = new CentreInteret();
                        $CI->setDesignation($value["description"])->setUserForCv($userCv);
                        $this->em->persist($CI);
                        $this->em->flush();
                    }
                    //j'insere un ensemble de competence qui est un tableau
                    foreach ($competence as $value) {
                        $Compe = new Competence();
                        $Compe->setUserForCv($userCv)
                            ->setDesignation($value["designation"])
                            ->setNiveauPourcent($value["pourcentage"]);
                        $this->em->persist($Compe);
                        $this->em->flush();
                    }
                    //j'insere un le contact qui n'est pas un tableau
                    $cont = new Contact();
                    $cont->setUserForCv($userCv)
                        ->setTel($contact["tel"])
                        ->setEmail($contact["email"])->setAdresse($contact["adresse"]);
                    $this->em->persist($cont);
                    $this->em->flush();
                    //j'insere un ensemble d'experience qui est un tableau
                    foreach ($experience as $value) {
                        $exp = new ExperienceProfessionnelle();
                        $exp->setUserForCv($userCv)
                            ->setPosteOccupe($value["poste"])
                            ->setNomEntreprise($value["entreprise"])->setAnneeOccupation($value["annee"]);
                        $this->em->persist($exp);
                        $this->em->flush();
                        //j'insere un ensemble des taches qui est un tableau lie aux experiences
                        if ($exp->getId()) {
                            foreach ($tache as $value) {
                                $Tache = new TacheEffectuer();
                                $Tache->setDescription($value["description"])
                                    ->setExperienceProfessionnelle($exp);
                                $this->em->persist($Tache);
                                $this->em->flush();
                            }
                        }
                    }
                    //j'insere un ensemble de formation qui est un tableau
                    foreach ($formation as $value) {
                        $forma = new Formation();
                        $forma->setUserForCv($userCv)
                            ->setAnnee($value["annee"])
                            ->setPays($value["pays"])
                            ->setVille($value["ville"])
                            ->setDiplome($value["diplome"])
                            ->setEcoleObtention($value["ecole"]);
                        $this->em->persist($forma);
                        $this->em->flush();
                    }
                    //j'insere un ensemble de langue qui est un tableau
                    foreach ($langue as $value) {
                        $lang = new Langue();
                        $lang->setUserForCv($userCv)
                            ->setDesignation($value["designation"])
                            ->setNiveauPourcent($value["pourcent"]);
                        $this->em->persist($lang);
                        $this->em->flush();
                    }
                    //j'insere un ensemble de logiciel qui est un tableau
                    foreach ($logiciel as $value) {
                        $log = new Logiciel();
                        $log->setUserForCv($userCv)
                            ->setDesignation($value["designation"])
                            ->setNiveauPourcent($value["pourcent"]);
                        $this->em->persist($log);
                        $this->em->flush();
                    }
                    //j'insere le profil
                    $prof = new Profil();
                    $prof->setUserForCv($userCv)->setDescription($profil["description"]);
                    $this->em->persist($prof);
                    $this->em->flush();

                    //pour les cv, on aura trois cv car on cree trois user qui possede chacun un cv
                    $monCv = new Cv();
                    $monCv->setUserForCv($userCv)->setNumCv($cv[$i]["numCv"])->setUser($user);
                    $this->em->persist($monCv);
                    $this->em->flush();
                    //creer le modele
                    if ($monCv->getId()) {
                        $model = new ModelCv();
                        //je creer juste un seul modele par cv
                        $model->setDesignation("modele 1")->setImage("model1.png")->setCreateur($user)
                            ->setPrix(1000)->setCv($monCv);
                        $this->em->persist($model);
                        $this->em->flush();
                    }
                }
            }
            if ($i <= 3) {
                $i = $i + 1;
            }
        }
        //valider la creation d'un user avec son cv
        //$this->em->flush();
    }
}
