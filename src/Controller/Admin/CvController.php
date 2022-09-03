<?php

namespace App\Controller\Admin;

use App\Repository\CvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{

    private $parent_page = 'Curicilium Vitae';

    /**
     * @Route("/my-account/my-curicilium-vitae", name="my_cv_index")
     */
    public function cv(CvRepository $cv)
    {
        //affichons les cv d'un user la date de creation, son profil,le poste recherche pour le cv
        return $this->render('admin/cv/index.html.twig',[
            'parent_page'=>$this->parent_page
        ]);
    }
}
