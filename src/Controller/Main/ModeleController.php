<?php

namespace App\Controller\Main;

use App\Repository\ModelCvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
class ModeleController extends AbstractController
{
    /**
     * @Route("/modeles", name="main_modele_index")
     */
    public function index(ModelCvRepository $modelCvRepository): Response
    {

        return $this->render('main/modele/index.html.twig', [
            'modeles' => $modelCvRepository->findAll(),
        ]);
    }
}
