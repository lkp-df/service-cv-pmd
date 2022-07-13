<?php

namespace App\Controller\Admin;

use App\Repository\CvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
   
    public function index(): Response
    {
        return $this->render('admin/client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
     /**
     * @Route("/client/models", name="client_model_index")
     */
    public function model(CvRepository $cv){

        //affichons les cv d'un user la date de creation, son profil,le poste recherche pour le cv

        return $this->render('admin/client/model.html.twig',
    []);
    }
}