<?php
namespace App\Service\Order;

use App\Entity\Commande;
use App\Service\Email\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;


class CommandeAbonnementService extends AbstractController{
    private $em;
    private $repository;
    private $orderRepository;
    private $emailService;
    public function __construct(EmailService $emailService, EntityManagerInterface $manager)
    {
        $this->em = $manager;
        $this->emailService = $emailService;
    }

    public function orderSendToEmail(Commande $order, $pdf= false){
        $theme = ($order->getState() == 'completed')? '7':'4';
        $page = ($order->getState() == 'completed')? 'facture':'order';
        $page = 'commande';
                
        $fichier = $order->getFacture().'.pdf';
        $email =  (new TemplatedEmail())
            ->from(new Address('contact@lest.sn', 'lest - Facture'))
            ->to($order->getUser()->getEmail())
            ->subject('Lest - Avis de facture')
            ->htmlTemplate('email/'.$page.'.html.twig');
            if($pdf){
                $email->attachFromPath($this->getParameter('order_pdf_directory') .DIRECTORY_SEPARATOR.$fichier,$fichier,'application/pdf');                
            }
            $email->context([
                'user'=>$order->getUser(),
                'theme' => $this->emailService->theme($theme),
                'order' => $order,
                'etat'=>$order->getState()
            ]);
            return $email;
    }

    
}