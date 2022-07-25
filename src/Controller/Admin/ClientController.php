<?php

namespace App\Controller\Admin;

use App\Repository\CvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    /**
     * @Route("/my-account/curicilium-vitae", name="client_cv_index")
     */
    public function model(CvRepository $cv)
    {
        //affichons les cv d'un user la date de creation, son profil,le poste recherche pour le cv
        return $this->render(
            'admin/client/model.html.twig'
        );
    }
}
