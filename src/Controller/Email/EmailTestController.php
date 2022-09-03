<?php

namespace App\Controller\Email;

use App\Entity\Commande;
use App\Entity\Order;
use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Service\Email\EmailService;
use App\Service\Order\CommandeAbonnementService;
use App\Service\Order\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailTestController extends AbstractController
{
    private $emailService;
    private $client;
    private $user;
    public function __construct(EmailService $emailService, UserRepository $userRepository)
    {

        $user = $userRepository->findOneBy([
            'email'=>'user@email.com'
        ]);
        if($user){
            $this->user = $user;
        }
        $this->emailService = $emailService;
    }
    /**
     * @Route("/email", name="email_index")
     */
    public function index(): Response
    {
        return $this->render('email/index.html.twig');
    }
    /**
     * @Route("/email/commande/abonnement/{id}", name="email_commande_abonnement")
     */
    public function commandeAbonnement(Commande $commande): Response
    {
        return $this->render('email/commande.html.twig',[
            'theme'=>$this->emailService->theme(4),
            'commande'=>$commande,
            'etat'=>$commande->getState(),
            'user'=>$this->user 
        ]);
    }
}
