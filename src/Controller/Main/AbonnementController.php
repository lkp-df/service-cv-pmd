<?php

namespace App\Controller\Main;

use App\Entity\Abonnement;
use App\Entity\Commande;
use App\Entity\CommandeItem;
use App\Entity\TypeAbonnement;
use App\Repository\AbonnementRepository;
use App\Repository\TypeAbonnementRepository;
use App\Service\Cart\CartAbonnementService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbonnementController extends AbstractController
{
    /**
     * @Route("/abonnement", name="abonnement_index")
     */
    public function index(TypeAbonnementRepository $typeAbonnementRepository): Response
    {
        return $this->render('main/abonnement/index.html.twig', [
            'types_abonnements' => $typeAbonnementRepository->findAll()
        ]);
    }
    /**
     * @Route("/abonnement/commande/new", name="abonnement_commande_new")
     */
    public function newCommande(Request $request, CartAbonnementService $cartAbonnementService): Response
    {
        $user = $this->getUser();
        if ($user) {
            $typeAbonnement = $cartAbonnementService->getCart();
            dump($typeAbonnement);
            

            $commande  = new Commande();
            $commande->setUser($user);
            $commande->setCreatedAt(new DateTime());
            $commande->setPaymentDue(new DateTime('+ 10 day'));
            $commande->setAdjustmentsTotal(0);
            $commande->setState('En attente');
            $commande->setNumber('00001');

            $commandeItem  = new CommandeItem();
            $commandeItem->setDuree($typeAbonnement->getDuree());
            $commandeItem->setType($typeAbonnement->getDesignation());
            $commandeItem->setPrix($typeAbonnement->getMontant());

            $commande->setTotal($typeAbonnement->getMontant());
            $commande->setItemsTotal($typeAbonnement->getMontant());
            $commande->addCommandeItem($commandeItem);
            if ($this->isCsrfTokenValid('new_commande_abonnement' . $typeAbonnement->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($commande);
                $entityManager->flush();
                $this->addFlash('success', 'La comnade a été enregistré');
                return $this->redirectToRoute('abonnement_commande_confirmation', ['id' => $commande->getId()], Response::HTTP_SEE_OTHER);
            } else {
                $this->addFlash('error', 'Une érreur a été détecté');
                return $this->redirectToRoute('abonnement_index', []);
            }
        } else {
            $this->addFlash('error', 'Une érreur a été détecté');
            return $this->redirectToRoute('abonnement_index', []);
        }
    }
    /**
     * @Route("/abonnement/panier/", name="abonnement_panier")
     */
    public function commande(Request $request, CartAbonnementService $cartAbonnementService): Response
    {
        if ($request->request->count() > 0) {
            $cartAbonnementService->addPost($request->request->get('type_abonnement_id'));
            $this->addFlash('success', "Le produit a été modifié avec succès.");
            return $this->redirectToRoute('cart_index');
        }
        // dd($cartAbonnementService->getCart());

        return $this->render('main/abonnement/panier.html.twig', [
            'type_abonnement' => $cartAbonnementService->getCart()
        ]);
    }
    /**
     * @Route("/commande/confirmation/{id}", name="abonnement_commande_confirmation")
     */
    public function confirmation(Abonnement $abonnement): Response
    {
        return $this->render('main/abonnement/commande_confirmation.html.twig',[
            'abonnement'=>$abonnement
        ]);
    }
    /**
     * @Route("cart/abonnement/add/{id}", name="cart_abonnement_add")
     */
    public function add(int $id, CartAbonnementService $cartAbonnementService)
    {
        $cartAbonnementService->add($id);
        return $this->redirectToRoute('abonnement_panier');
    }
}
