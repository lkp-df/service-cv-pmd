<?php

namespace App\DataFixtures;

use App\Entity\CentreInteret;
use App\Entity\Competence;
use App\Entity\Contact;
use App\Entity\Cv;
use App\Entity\ExperienceProfessionnelle;
use App\Entity\Formation;
use App\Entity\Langue;
use App\Entity\Logiciel;
use App\Entity\ModelCv;
use App\Entity\Profil;
use App\Entity\TacheEffectuer;
use App\Entity\UserForCv;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class CvFixtures extends Fixture implements DependentFixtureInterface
{
    private $em;
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }
    public function load(ObjectManager $manager)
    {
        $users =
            [
                ["nom" => "Ngoulou", "prenom" => "Pepin", "avatar" => "lkp.png", "poste" => "developper Php"],
                ["nom" => "Dieme", "prenom" => "Mamadou", "avatar" => "nans.png", "poste" => "developper Java"],
                ["nom" => "Tounkara", "prenom" => "Malick", "avatar" => "tkr.png", "poste" => "developper Php"]
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
        //$cv = ["numCv" => 1]; //on mettra un compteur


        //insertion des trois users
        foreach ($users as $value) {
            $user = new UserForCv();

            $user->setNom($value["nom"])->setPrenom($value["prenom"])->setSexe('Homme')
                ->setAvatar($value["avatar"])->setPosteRechercheOccupe($value["poste"]);
            $this->em->persist($user);
            $this->em->flush();
            //inserons les elements du user: centre interet, formation,...
            if ($user->getId()) {
                $i = 1;
                //j'insere un ensemble de centre d'interet qui est un tableau
                foreach ($ci as $value) {
                    $CI = new CentreInteret();
                    $CI->setDesignation($value["description"])->setUserForCv($user);
                    $this->em->persist($CI);
                    $this->em->flush();
                }
                //j'insere un ensemble de competence qui est un tableau
                foreach ($competence as $value) {
                    $Compe = new Competence();
                    $Compe->setUserForCv($user)
                        ->setDesignation($value["designation"])
                        ->setNiveauPourcent($value["pourcentage"]);
                    $this->em->persist($Compe);
                    $this->em->flush();
                }
                //j'insere un le contact qui n'est pas un tableau
                $cont = new Contact();
                $cont->setUserForCv($user)
                    ->setTel($contact["tel"])
                    ->setEmail($contact["email"])->setAdresse($contact["adresse"]);
                $this->em->persist($cont);
                $this->em->flush();
                //j'insere un ensemble d'experience qui est un tableau
                foreach ($experience as $value) {
                    $exp = new ExperienceProfessionnelle();
                    $exp->setUserForCv($user)
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
                    $forma->setUserForCv($user)
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
                    $lang->setUserForCv($user)
                        ->setDesignation($value["designation"])
                        ->setNiveauPourcent($value["pourcent"]);
                    $this->em->persist($lang);
                    $this->em->flush();
                }
                //j'insere un ensemble de logiciel qui est un tableau
                foreach ($logiciel as $value) {
                    $log = new Logiciel();
                    $log->setUserForCv($user)
                        ->setDesignation($value["designation"])
                        ->setNiveauPourcent($value["pourcent"]);
                    $this->em->persist($log);
                    $this->em->flush();
                }
                //j'insere le profil
                $prof = new Profil();
                $prof->setUserForCv($user)->setDescription($profil["description"]);
                $this->em->persist($prof);
                $this->em->flush();

                //j'insere le numero du cv
                $numCv = new Cv();
                $numCv->setUserForCv($user)->setNumCv($i);
                $this->em->persist($numCv);
                $this->em->flush();
                //creer le modele
                if ($numCv->getId()) {
                    $model = new ModelCv();
                    $model->setCreateur($this->getReference('_user_admin@mail.com'));
                    //je creer juste un seul modele par cv
                    $model->setDesignation("modele 1")->setImage("model1.png")
                        ->setPrix(1000)->setCv($numCv);
                        $this->em->persist($model);
                        $this->em->flush();
                }
            }
        }
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
