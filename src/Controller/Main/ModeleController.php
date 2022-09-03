<?php

namespace App\Controller\Main;

use App\Entity\ModelCv;
use App\Repository\ModelCvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ModeleController extends AbstractController
{
    /**
     * @Route("/modeles", name="modeles_index")
     */
    public function index(ModelCvRepository $modelCvRepository): Response
    {
        return $this->render('main/modele/index.html.twig', [
            'modeles' => $modelCvRepository->findAll(),
        ]);
    }
    /**
     * @Route("/modeles/choice/{id}", name="modeles_choice")
     */
    public function choice(ModelCv $modelCv, SessionInterface $sessionInterface): Response
    {
        $sessionInterface->set('choice',$modelCv->getId());
        if(!$this->getUser()){
            $this->addFlash('info','Mercie de vous connecter ou creer un compte');
            return $this->redirectToRoute('app_register');
        }
        return $this->render('main/modele/choice.html.twig', [
        ]);
    }
}
